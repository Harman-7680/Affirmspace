<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RegistrationPaymentController extends Controller
{
    public function show()
    {
        $amount = \DB::table('registration_settings')->value('registration_fee');

        return view('payment.registration', compact('amount'));
    }

    public function createOrder(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amount = \DB::table('registration_settings')->value('registration_fee');

        $order = $api->order->create([
            'amount'   => $amount * 100,
            'currency' => 'INR',
            'receipt'  => 'reg_' . auth()->id(),
        ]);

        return response()->json([
            'order_id' => $order->id,
            'amount'   => $amount,
            'key'      => config('services.razorpay.key'),
        ]);
    }

    public function success(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'nullable',
        ]);

        $user = auth()->user();

        if ($user->is_paid == 1) {
            return redirect()->route('feed');
        }

        $user->update(['is_paid' => 1]);

        if (! $user->email_verified_at) {
            event(new \Illuminate\Auth\Events\Registered($user));
        }

        return redirect()->route('verification.notice')
            ->with('success', 'Payment successful! Please verify your email.');
    }
}
