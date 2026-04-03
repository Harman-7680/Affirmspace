<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AreaPrice;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
// use Stripe\Checkout\Session as CheckoutSession;
// use Stripe\Stripe;
use Razorpay\Api\Api;

class ApiEventController extends Controller
{
    public function feed()
    {
        $user = Auth::user();
        abort_if($user->role != 0, 403, 'Unauthorized access');

        $userAddress  = $user->address ?? '';
        $addressParts = array_map('trim', explode(',', $userAddress));

        $events = Event::where('status', 'approved')
            ->where(function ($query) use ($addressParts) {
                foreach ($addressParts as $part) {
                    $part = strtolower($part);
                    $query->orWhereRaw('LOWER(city) LIKE ?', ["%{$part}%"]);
                }
            })
            ->get();

        return response()->json([
            'user'   => $user,
            'events' => $events,
        ]);
    }

    // Store Event and Create Razorpay Checkout Session
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'event_date'    => 'required|date',
            'timing_slot'   => 'required|string',
            'image'         => 'nullable|image|max:2048',
            'area_price_id' => 'required|exists:area_prices,id',
        ]);

        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('events', 'public')
            : null;

        $timingSlotMap = [
            'morning'   => '09:00:00',
            'afternoon' => '12:00:00',
            'evening'   => '16:00:00',
            'night'     => '20:00:00',
        ];

        $timing = $request->event_date . ' ' .
            ($timingSlotMap[strtolower($request->timing_slot)] ?? '09:00:00');

        $areaPrice = AreaPrice::findOrFail($request->area_price_id);

        $location = $this->getLatLng($request->city);
        if (! $location || empty($location['lat']) || empty($location['lng'])) {
            return back()->withErrors(['city' => 'Invalid city. Please enter a valid location.'])->withInput();
        }

        $event = Event::create([
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            // 'city'       => $request->city,
            // city me hi JSON store
            'city'       => json_encode([
                'address' => $request->city,
                'lat'     => $location['lat'] ?? null,
                'lng'     => $location['lng'] ?? null,
            ]),
            'timing'     => $timing,
            'image'      => $imagePath,
            'area_range' => $areaPrice->area_range,
            'amount'     => $areaPrice->amount,
        ]);

        /** Razorpay Order */
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

// Base amount
        $baseAmount = $areaPrice->amount;

// GST calculation
        $gstRate     = 18;
        $gstAmount   = round(($baseAmount * $gstRate) / 100, 2);
        $totalAmount = $baseAmount + $gstAmount;

        $order = $api->order->create([
            'receipt'  => 'event_' . $event->id,
            'amount'   => (int) round($totalAmount * 100),
            'currency' => 'INR',
            'notes'    => [
                'event_id'     => $event->id,
                'event_name'   => $event->name,
                'base_amount'  => $baseAmount,
                'gst_rate'     => '18%',
                'gst_amount'   => $gstAmount,
                'total_amount' => $totalAmount,
                'source'       => 'app',
            ],
        ]);

        $checkoutUrl = route('api.events.razorpay.webview', [
            'order_id' => $order->id,
            'event_id' => $event->id,
        ]);

        return response()->json([
            'message'      => 'Event created. Proceed to payment.',
            'checkout_url' => $checkoutUrl,
            'event_id'     => $event->id,
            'amount'       => $baseAmount,
            'gst_amount'   => $gstAmount,
            'total_amount' => $totalAmount,
        ]);
    }

    public function razorpayWebview($order_id, $event_id)
    {
        $event = Event::findOrFail($event_id);

        return view('payment.api.razorpay', [
            'order_id' => $order_id,
            'event'    => $event,
            'amount'   => $event->amount,
        ]);
    }

    // Payment success
    public function success($id)
    {
        $event = Event::findOrFail($id);
        // $event->is_paid = true;
        // $event->save();

        // Mail::raw("New Event '{$event->name}' created in {$event->city}, pending approval.", function ($msg) {
        //     $msg->to("admin@gmail.com")->subject("New Event Pending Approval");
        // });

        // return response()->json(['success' => true, 'message' => 'Payment successful! Event submitted for approval.']);
        return view('payment.success');
    }

    // Payment cancel
    public function cancel($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();

        // return response()->json(['success' => false, 'message' => 'Payment cancelled.']);
        return view('payment.cancel');
    }

    public function verifyPayment(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            $event             = Event::findOrFail($request->event_id);
            $event->is_paid    = true;
            $event->payment_id = $request->razorpay_payment_id;
            $event->save();

            Mail::send('emails.event_payment_success', ['event' => $event], function ($msg) use ($event) {
                $msg->to("admin@gmail.com")
                    ->subject("New Paid Event: {$event->name} Pending Approval");
            });

            return response()->json(['success' => true]);

        } catch (\Exception $e) {

            Event::find($request->event_id)?->delete();

            return response()->json(['success' => false], 400);
        }
    }

    public function getLatLng($city)
    {
        $apiKey = env('LOCATIONIQ_KEY');

        $response = \Http::get("https://us1.locationiq.com/v1/search.php", [
            'key'    => $apiKey,
            'q'      => $city,
            'format' => 'json',
            'limit'  => 1,
        ]);

        if ($response->successful() && isset($response[0])) {
            return [
                'lat' => $response[0]['lat'],
                'lng' => $response[0]['lon'],
            ];
        }

        return null;
    }
}
