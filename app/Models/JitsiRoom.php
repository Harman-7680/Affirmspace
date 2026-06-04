<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JitsiRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_name',
        'room_code',
        'created_by',
        'description',
        'max_users',
        'jitsi_link',
        'duration_minutes',
        'start_time',
        'end_time',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'jitsi_room_user')
            ->withPivot('is_admin')
            ->withTimestamps();
    }

}
