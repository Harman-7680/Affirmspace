<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TempAppointment extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'email',
        'message_body',
        'availability_id',
        'razorpay_order_id',
        'razorpay_payment_id',
        'base_amount',
    ];
}
