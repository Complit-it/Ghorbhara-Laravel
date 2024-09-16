<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Passport\HasApiTokens;

class Property extends Model 
{
    use HasFactory;

    // protected $fillable = [
    //     'title',
    //     'email',
    //     'phone',
    //     'dob',
    //     'gender',
    //     'address',
    //     'photo_url',
    //     'phone_otp',
    //     'email_otp',
    //     'fcm_token',
    //     'password',
    //     'userType'
    // ];
}
