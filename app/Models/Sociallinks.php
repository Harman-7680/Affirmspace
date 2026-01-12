<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sociallinks extends Model
{
    use HasFactory;

    protected $table = 'sociallinks';

    protected $fillable = [
        'user_id',
        'facebook',
        'instagram',
        'twitter',
        'youtube',
        'github',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
