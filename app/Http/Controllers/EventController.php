<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AreaPrice;
use App\Models\Event;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session as CheckoutSession;
use Stripe\Stripe;

class EventController extends Controller
{
    // Store Event and Redirect to Stripe
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required',
            'city'          => 'required',
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

        $time   = $timingSlotMap[$request->timing_slot] ?? '09:00:00';
        $timing = $request->event_date . ' ' . $time;

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

        /** Stripe */
        Stripe::setApiKey(config('services.stripe.secret'));

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
            'success_url' => route('event.success', $event->id),
            'cancel_url'  => route('event.cancel', $event->id),
        ]);

        return redirect($session->url);
    }

    // Payment success
    // use Illuminate\Support\Facades\Mail;

    public function success($id)
    {
        $event          = Event::findOrFail($id);
        $event->is_paid = true;
        $event->save();

        Mail::send('emails.event_payment_success', ['event' => $event], function ($msg) use ($event) {
            $msg->to("admin@gmail.com")
                ->subject("New Paid Event: {$event->name} Pending Approval");
        });

        return redirect()->route('notifications')->with('success', 'Payment successful! Event submitted for approval.');
    }

    // Payment cancel
    public function cancel($id)
    {
        $event = Event::findOrFail($id);
        $event->delete();
        return redirect()->route('notifications')->with('error', 'Payment cancelled.');
    }

    public function isValidCity($city)
    {
        $apiKey = env('LOCATIONIQ_KEY');

        $url = "https://us1.locationiq.com/v1/search.php?key={$apiKey}&q=" . urlencode($city) . "&format=json";

        $response = Http::get($url);

        return $response->successful() && count($response->json()) > 0;
    }
}
