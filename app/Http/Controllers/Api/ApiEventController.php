<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\AreaPrice;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

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

    // Store Event and Create Stripe Checkout Session
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'city'          => 'required|string|max:255',
            'event_date'    => 'required|date',   // Event Date
            'timing_slot'   => 'required|string', // (morning, afternoon, evening, night)
            'image'         => 'nullable|image|max:2048',
            'area_price_id' => 'required|exists:area_prices,id',
        ]);

        // Store image if provided
        $imagePath = $request->hasFile('image')
            ? $request->file('image')->store('events', 'public')
            : null;

        // Map slots to start times
        $timingSlotMap = [
            'morning'   => '09:00:00',
            'afternoon' => '12:00:00',
            'evening'   => '16:00:00',
            'night'     => '20:00:00',
        ];

        $time   = $timingSlotMap[strtolower($request->timing_slot)] ?? '09:00:00';
        $timing = $request->event_date . ' ' . $time; // valid datetime

        /** Fetch price from DB */
        $areaPrice = AreaPrice::findOrFail($request->area_price_id);

        $event = Event::create([
            'user_id'    => Auth::id(),
            'name'       => $request->name,
            'city'       => $request->city,
            'timing'     => $timing,
            'image'      => $imagePath,
            'area_range' => $areaPrice->area_range,
            'amount'     => $areaPrice->amount,
        ]);

        // Stripe Checkout
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $session = CheckoutSession::create([
            'payment_method_types' => ['card'],
            'line_items'           => [[
                'price_data' => [
                    'currency'     => 'inr',
                    'product_data' => [
                        'name' => "Event Creation ({$event->name})",
                        'description'  => "Area: {$areaPrice->area_range}",
                    ],
                    'unit_amount' => $areaPrice->amount * 100,
                ],
                'quantity'             => 1,
            ]],
            'mode'        => 'payment',
            'success_url' => route('api.events.success', ['id' => $event->id]),
            'cancel_url'  => route('api.events.cancel', ['id' => $event->id]),
        ]);

        return response()->json([
            'message'      => 'Event created successfully. Redirect to Stripe checkout.',
            'checkout_url' => $session->url,
            'session_id'   => $session->id,
            'event_id'     => $event->id,
            'event'        => [
                'id'     => $event->id,
                'name'   => $event->name,
                'city'   => $event->city,
                'timing' => \Carbon\Carbon::parse($event->timing)->format('d M Y h:i A'),
                'slot'   => ucfirst($request->timing_slot), // also send slot separately
                'image'  => $event->image ? asset('storage/' . $event->image) : asset('images/avatars/avatar-1.jpg'),
            ],
        ]);
    }

    // Payment success
    public function success($id)
    {
        $event          = Event::findOrFail($id);
        $event->is_paid = true;
        $event->save();

        Mail::raw("New Event '{$event->name}' created in {$event->city}, pending approval.", function ($msg) {
            $msg->to("admin@gmail.com")->subject("New Event Pending Approval");
        });

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
        $request->validate([
            'session_id' => 'required|string',
            'event_id'   => 'required|integer',
        ]);

        Stripe::setApiKey(env('STRIPE_SECRET'));

        try {
            $session = CheckoutSession::retrieve($request->session_id);

            if ($session->payment_status === 'paid') {
                $event          = \App\Models\Event::findOrFail($request->event_id);
                $event->is_paid = true;
                $event->save();

                // Notify admin
                Mail::raw("New Event '{$event->name}' created in {$event->city}, pending approval.", function ($msg) {
                    $msg->to('admin@gmail.com')->subject('New Event Pending Approval');
                });

                return response()->json([
                    'success' => true,
                    'message' => 'Payment verified successfully.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Payment not completed yet.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error verifying payment: ' . $e->getMessage(),
            ], 500);
        }
    }
}
