<?php
namespace App\Http\Controllers;

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

        if (auth()->user()->bank_status === 'pending') {
            return back()->with('error', 'Bank details already submitted.');
        }

        // ❗ Abhi Razorpay nahi hai — to sirf status update
        $user->bank_status           = 'pending';
        $user->bank_rejection_reason = null;

        // Future me yahin Razorpay API lagegi
        // $user->razorpay_account_id = 'acc_xxxxx';

        $user->save();

        return back()->with('success', 'Bank details submitted. Verification in progress.');
    }
}
