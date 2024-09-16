<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OTPVerification extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_no',
        'otp',
        'status',
        'created_at',
        'valid_till',
        'updated_at',
    ];
}
