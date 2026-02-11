<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use DB;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

class AppRegistrationPaymentController extends Controller
{
    /**
     * STEP 1 — Fetch Amount
     */ 
    public function amount(Request $request)
    {
        $base = DB::table('registration_settings')->value('registration_fee');

        $extra30  = round($base * 0.30, 2);
        $subTotal = $base + $extra30;
        $gst      = round($subTotal * 0.18, 2);
        $total    = round($subTotal + $gst, 2);

        return response()->json([
            'base_amount' => $base,
            'extra_30'    => $extra30,
            'gst_18'      => $gst,
            'total'       => $total,
        ]);
    }

    /**
     * STEP 2 — Create Razorpay Order
     */
    public function createOrder(Request $request)
    {
        $user = $request->user();

        if ($user->is_paid == 1) {
            return response()->json(['message' => 'Already paid'], 400);
        }

        $base = DB::table('registration_settings')->value('registration_fee');

        $extra30  = round($base * 0.30, 2);
        $subTotal = $base + $extra30;
        $gst      = round($subTotal * 0.18, 2);
        $total    = round($subTotal + $gst, 2);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $order = $api->order->create([
            'amount'   => (int) ($total * 100),
            'currency' => 'INR',
            'receipt'  => 'app_reg_' . $user->id,
            'notes'    => [
                'user_id'      => $user->id,
                'first_name'   => $user->first_name,
                'last_name'    => $user->last_name,
                'email'        => $user->email,
                'role'         => $user->role,
                'base_amount'  => $base,
                'extra_30'     => $extra30,
                'gst_18'       => $gst,
                'total_amount' => $total,
            ],
        ]);

        return response()->json([
            'order_id'    => $order->id,
            'amount'      => $total,
            'payment_url' => route('app.payment.page', $order->id),
        ]);
    }

    /**
     * STEP 3 — WebView Payment Page
     */
    public function paymentPage($order_id)
    {
        return view('payment.appRegistration', compact('order_id'));
    }

    /**
     * STEP 4 — Success (VERIFY PAYMENT)
     */
    public function success(Request $request)
    {
        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (SignatureVerificationError $e) {
            return view('payment.appCancel', ['error' => 'Payment verification failed']);
        }

        $order  = $api->order->fetch($request->razorpay_order_id);
        $userId = $order->notes->user_id ?? null;

        if ($userId) {
            $user = User::find($userId);

            if ($user && $user->is_paid == 0) {
                $user->update(['is_paid' => 1]);

                if (! $user->email_verified_at) {
                    event(new Registered($user));
                }
            }
        }

        return view('payment.appSuccess');
    }

    /**
     * STEP 5 — Cancel
     */
    public function cancel()
    {
        return view('payment.appCancel');
    }
}
