<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendChatGroupMember extends Model
{
    protected $fillable = [
        'group_id',
        'user_id',
        'is_admin',
    ];

    public function group()
    {
        return $this->belongsTo(FriendChatGroup::class, 'group_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
