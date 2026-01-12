<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    protected $fillable = [
        'counselor_id',
        'user_id',
        'rating',
        'review',
    ];

    public function counselor()
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
