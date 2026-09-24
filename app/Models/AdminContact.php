<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminContact extends Model
{
    protected $fillable = [
        'type',
        'name',
        'email',
        'subject',
        'message',
    ];
}
