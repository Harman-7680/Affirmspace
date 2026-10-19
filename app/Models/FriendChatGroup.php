<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FriendChatGroup extends Model
{
    protected $fillable = [
        'name',
        'image',
        'created_by',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function members()
    {
        return $this->belongsToMany(
            User::class,
            'friend_chat_group_members',
            'group_id',
            'user_id'
        )->withPivot('is_admin')->withTimestamps();
    }

    public function messages()
    {
        return $this->hasMany(
            FriendChatGroupMessage::class,
            'group_id'
        );
    }
}
