<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrationSetting extends Model
{
    protected $table = 'registration_settings';

    protected $fillable = [
        'registration_fee',
    ];

    public $timestamps = true;
}
