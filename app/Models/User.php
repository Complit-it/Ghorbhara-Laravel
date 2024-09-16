<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable implements LaratrustUser
{
    use HasApiTokens, HasFactory, Notifiable;
    use HasRolesAndPermissions;

    /**
     * The attributes that are mass assignable.c
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'dob',
        'gender',
        'address',
        'photo_url',
        'phone_otp',
        'email_otp',
        'fcm_token',
        'password',
        'userType',
        'google_id'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'otp',
        'password',
        'remember_token',
        'fcm_token',
        'created_at',
        'updated_at',
        'email_verified_at',
        'phone_verified_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function properties()
    {
        return $this->hasMany(GbTrnProperty::class, 'user_id');
    }

    public function chats(): HasMany
    {
        return $this->hasMany(Chat::class, 'created_by');
    }

//     public function routeNotificationForOneSignal() : array{
//         return ['tags'=>['key'=>'userId','relation'=>'=', 'value'=>(string)($this->id)]];
//     }

//     public function sendNewMessageNotification(array $data) : void {
//         $this->notify(new MessageSent($data));
//     }
}
