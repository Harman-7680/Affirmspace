<?php
namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class DatingMessage extends Model
{
    protected $table = 'dating_messages';
    
    protected $fillable = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
}
