<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventChat extends Model
{
    protected $fillable = [
        'event_id',
        'sender_id',
        'conversation_user_id',
        'message',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
