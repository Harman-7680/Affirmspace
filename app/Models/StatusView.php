<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusView extends Model
{
    protected $fillable = [
        'status_id',
        'viewer_id',
    ];
}
