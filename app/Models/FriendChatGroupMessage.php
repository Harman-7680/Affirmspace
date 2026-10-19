<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendChatGroupMessage extends Model
{
    protected $fillable = [
        'group_id',
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

    public function group()
    {
        return $this->belongsTo(
            FriendChatGroup::class,
            'group_id'
        );
    }
}
