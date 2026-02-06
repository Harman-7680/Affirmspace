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

        $user = auth()->user();

        $amount = \DB::table('registration_settings')->value('registration_fee');

        // GST
        $gstRate     = 18;
        $gstAmount   = round(($amount * $gstRate) / 100, 2);
        $totalAmount = $amount + $gstAmount;

        $order = $api->order->create([
            'amount'   => $totalAmount * 100,
            'currency' => 'INR',
            'receipt'  => 'reg_' . $user->id,
            'notes'    => [
                'first_name'   => $user->first_name,
                'last_name'    => $user->last_name,
                'email'        => $user->email,
                'role'         => $user->role,
                'base_amount'  => $amount,
                'gst_18%'      => $gstAmount,
                'total_amount' => $totalAmount,
            ],
        ]);

        return response()->json([
            'order_id'     => $order->id,
            'amount'       => $amount,
            'gst_amount'   => $gstAmount,
            'total_amount' => $totalAmount,
            'key'          => config('services.razorpay.key'),
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
