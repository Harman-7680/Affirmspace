<?php
namespace App\Http\Controllers;

use App\Models\BankDetail;
use Illuminate\Http\Request;

class BankDetailsController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'account_holder_name' => 'required',
            'account_number'      => 'required',
            'ifsc'                => 'required',
            'pan'                 => 'required',
            'phone'               => 'required',
            'email'               => 'required|email',
        ]);

        $user = auth()->user();

        if (in_array($user->bank_status, ['pending', 'verified'])) {
            return back()->with('error', 'Bank details already submitted.');
        }

        // updateOrCreate
        BankDetail::updateOrCreate(
            ['user_id' => $user->id], // condition
            [
                'account_holder_name' => $request->account_holder_name,
                'account_number'      => $request->account_number,
                'ifsc'                => $request->ifsc,
                'pan'                 => $request->pan,
                'phone'               => $request->phone,
                'email'               => $request->email,
            ]
        );

        // ❗ Abhi Razorpay nahi hai — to sirf status update
        $user->bank_status           = 'pending';
        $user->bank_rejection_reason = null;

        // Future me yahin Razorpay API lagegi
        // $user->razorpay_account_id = 'acc_xxxxx';

        $user->save();

        return back()->with('success', 'Bank details submitted. Verification in progress.');
    }

    public function requestChange()
    {
        $user = auth()->user();

        if ($user->bank_status !== 'verified') {
            return back()->with('error', 'You cannot change bank right now.');
        }

        // Reset old bank
        $user->bank_status           = 'change_requested';
        $user->bank_rejection_reason = null;
        $user->razorpay_account_id   = null; // IMPORTANT
        $user->save();

        return back()->with('success', 'Now you can update your bank details.');
    }
}
