<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselorAvailability extends Model
{
    protected $fillable = [
        'counselor_id',
        'available_date',
        'start_time',
        'end_time',
    ];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }
}
