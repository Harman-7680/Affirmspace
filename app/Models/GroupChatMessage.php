<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupChatMessage extends Model
{
    protected $fillable = [
        'room_id',
        'user_id',
        'message',
        'attachment_path',
        'attachment_name',
        'attachment_mime',
        'attachment_size',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function room()
    {
        return $this->belongsTo(JitsiRoom::class, 'room_id');
    }
}
