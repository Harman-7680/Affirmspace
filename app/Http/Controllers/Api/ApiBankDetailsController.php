<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ApiBankDetailsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'account_holder_name' => 'required|string',
            'account_number'      => 'required|string',
            'ifsc'                => 'required|string',
            'pan'                 => 'required|string',
            'phone'               => 'required|string',
            'email'               => 'required|email',
        ]);

        $user = auth()->user();

        if (in_array($user->bank_status, ['pending', 'verified'])) {
            return response()->json([
                'status'  => false,
                'message' => 'Bank details already submitted.',
            ], 400);
        }

        $user->bank_status           = 'pending';
        $user->bank_rejection_reason = null;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Bank details submitted. Verification in progress.',
        ], 200);
    }

    public function requestChange()
    {
        $user = auth()->user();

        if ($user->bank_status !== 'verified') {
            return response()->json([
                'status'  => false,
                'message' => 'You cannot change bank right now.',
            ], 400);
        }

        $user->bank_status           = 'change_requested';
        $user->bank_rejection_reason = null;
        $user->razorpay_account_id   = null;
        $user->save();

        return response()->json([
            'status'  => true,
            'message' => 'Now you can update your bank details.',
        ], 200);
    }
}
