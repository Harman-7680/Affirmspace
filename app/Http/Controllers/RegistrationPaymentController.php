<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Razorpay\Api\Api;

class RegistrationPaymentController extends Controller
{
    // public function show()
    // {
    //     $user = auth()->user();

    //     $amount = \DB::table('registration_settings')->value('registration_fee') ?? 0;

    //     // If payment already done OR fee disabled
    //     if ($user->is_paid == 1 || $amount == 0) {

    //         if ($user->role == 1) {
    //             return redirect()->route('profile');
    //         }

    //         return redirect()->route('feed');
    //     }

    //     return view('payment.registration', compact('amount'));
    // }

    public function show()
    {
        $user = auth()->user();

        // Admin ki registration fee
        $baseAmount = \DB::table('registration_settings')
            ->value('registration_fee') ?? 0;

        if ($user->is_paid == 1 || $baseAmount == 0) {
            if ($user->role == 1) {
                return redirect()->route('profile');
            }

            return redirect()->route('feed');
        }

        // Country detection
        $countryCode = 'IN';

        try {
            $ip = request()->ip();

            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                $response = \Illuminate\Support\Facades\Http::timeout(5)
                    ->get("https://ipapi.co/{$ip}/country/");

                if ($response->successful()) {
                    $detectedCountry = strtoupper(trim($response->body()));

                    if (preg_match('/^[A-Z]{2}$/', $detectedCountry)) {
                        $countryCode = $detectedCountry;
                    }
                }
            }
        } catch (\Exception $e) {
            // India remains default
        }

        $pricing = config('country_pricing.' . $countryCode) ?? config('country_pricing.DEFAULT');

        // Country-wise registration amount
        $amount = round(
            ($baseAmount * $pricing['percentage']) / 100,
            2
        );

        $currency = $pricing['currency'];

        // GST
        $gstRate = config('country_pricing.gst_rate');

        $gstAmount = round(
            ($amount * $gstRate) / 100,
            2
        );

        $totalAmount = $amount + $gstAmount;

        return view('payment.registration', compact(
            'amount',
            'currency',
            'gstRate',
            'gstAmount',
            'totalAmount'
        ));
    }

    // public function createOrder(Request $request)
    // {
    //     $api = new Api(
    //         config('services.razorpay.key'),
    //         config('services.razorpay.secret')
    //     );

    //     $user = auth()->user();

    //     $amount = \DB::table('registration_settings')->value('registration_fee');

    //     // GST
    //     $gstRate     = 18;
    //     $gstAmount   = round(($amount * $gstRate) / 100, 2);
    //     $totalAmount = $amount + $gstAmount;

    //     $order = $api->order->create([
    //         'amount'   => $totalAmount * 100,
    //         'currency' => 'INR',
    //         'receipt'  => 'reg_' . $user->id,
    //         'notes'    => [
    //             'first_name'   => $user->first_name,
    //             'last_name'    => $user->last_name,
    //             'email'        => $user->email,
    //             'role'         => $user->role,
    //             'base_amount'  => $amount,
    //             'gst_18%'      => $gstAmount,
    //             'total_amount' => $totalAmount,
    //         ],
    //     ]);

    //     return response()->json([
    //         'order_id'     => $order->id,
    //         'amount'       => $amount,
    //         'gst_amount'   => $gstAmount,
    //         'total_amount' => $totalAmount,
    //         'key'          => config('services.razorpay.key'),
    //     ]);
    // }

    public function createOrder(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $user = auth()->user();

        $baseAmount = \DB::table('registration_settings')
            ->value('registration_fee');

        if (! $baseAmount || $baseAmount <= 0) {
            return response()->json([
                'message' => 'Registration fee is not available.',
            ], 400);
        }

        // Country detection
        $countryCode = 'IN';

        try {
            $ip = $request->ip();

            if ($ip !== '127.0.0.1' && $ip !== '::1') {
                $response = \Illuminate\Support\Facades\Http::timeout(5)
                    ->get("https://ipapi.co/{$ip}/country/");

                if ($response->successful()) {
                    $detectedCountry = strtoupper(trim($response->body()));

                    if (preg_match('/^[A-Z]{2}$/', $detectedCountry)) {
                        $countryCode = $detectedCountry;
                    }
                }
            }
        } catch (\Exception $e) {
            // India remains default
        }

        // Country-wise pricing
        $pricing = config('country_pricing.' . $countryCode) ?? config('country_pricing.DEFAULT');

        // Country percentage
        $amount = round(
            ($baseAmount * $pricing['percentage']) / 100,
            2
        );

        $currency = $pricing['currency'];

        // GST
        $gstRate = config('country_pricing.gst_rate');

        $gstAmount = round(
            ($amount * $gstRate) / 100,
            2
        );

        $totalAmount = round(
            $amount + $gstAmount,
            2
        );

        $order = $api->order->create([
            'amount'   => (int) round($totalAmount * 100),
            'currency' => $currency,
            'receipt'  => 'reg_' . $user->id,

            'notes'    => [
                'first_name'          => $user->first_name,
                'last_name'           => $user->last_name,
                'email'               => $user->email,
                'role'                => $user->role,
                'country_code'        => $countryCode,
                'currency'            => $currency,
                'base_amount'         => $baseAmount,
                'percentage'          => $pricing['percentage'],
                'registration_amount' => $amount,
                'gst_rate'            => $gstRate . '%',
                'gst_amount'          => $gstAmount,
                'total_amount'        => $totalAmount,
            ],
        ]);

        return response()->json([
            'order_id'     => $order->id,
            'amount'       => $amount,
            'gst_amount'   => $gstAmount,
            'total_amount' => $totalAmount,
            'currency'     => $currency,
            'country_code' => $countryCode,
            'gst_rate'     => $gstRate,
            'key'          => config('services.razorpay.key'),
        ]);
    }
    public function success(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            // Verify Razorpay Signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {

            return redirect()->route('feed')
                ->with('error', 'Payment verification failed.');
        }

        $user = auth()->user();

        if (! $user) {
            abort(403);
        }

        // Prevent duplicate update
        if ($user->is_paid == 1) {
            return redirect()->route('feed');
        }

        // Optional: Extra safety – check order receipt belongs to user
        $order = $api->order->fetch($request->razorpay_order_id);

        if ($order->status !== 'paid') {
            abort(403, 'Payment not completed.');
        }

        if ($order->receipt !== 'reg_' . $user->id) {
            abort(403, 'Order mismatch.');
        }

        // Store payment id securely
        $user->update([
            'is_paid'    => 1,
            'payment_id' => $request->razorpay_payment_id,
        ]);

        // if (! $user->email_verified_at) {
        //     event(new \Illuminate\Auth\Events\Registered($user));
        // }

        return redirect()->route('verification.notice')
            ->with('success', 'Payment successful! Please verify your email.');
    }
}
