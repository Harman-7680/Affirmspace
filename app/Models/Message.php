<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Message.php

class Message extends Model
{
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'subject',
        'message_body',
        'email',
        'status',
        'availability_id',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function availability()
    {
        return $this->belongsTo(CounselorAvailability::class, 'availability_id');
    }

}
