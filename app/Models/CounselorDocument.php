<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CounselorDocument extends Model
{
    protected $fillable = [
        'user_id',
        'document1',
        'document2',
        'document3',
    ];
}
