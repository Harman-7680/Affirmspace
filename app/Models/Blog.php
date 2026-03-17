<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
        'slug',
        'short_description',
        'long_description',
        'image',
        'parent_id',
        'name',
        'comment',
        'approved',
        'category',
    ];

}
