<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tweet extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'paragraph',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
