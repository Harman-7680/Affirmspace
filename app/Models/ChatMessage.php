<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $table = 'chatmessages';

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'attachment_path',
        'attachment_name',
        'attachment_mime',
        'attachment_size',
    ];
}
