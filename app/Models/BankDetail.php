<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankDetail extends Model
{
    protected $fillable = [
        'user_id',
        'account_holder_name',
        'account_number',
        'ifsc',
        'pan',
        'phone',
        'email',
    ];
}
