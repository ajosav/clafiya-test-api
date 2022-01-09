<?php

namespace App\Models;

use App\Traits\Uuids;
use App\Facades\ClafiyaUtil;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Notifications\Notifiable;
use App\Notifications\WelcomeNotification;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\CanResetPassword;
use App\Notifications\PasswordResetNotification;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;

class User extends Authenticatable implements MustVerifyEmail, CanResetPassword
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, Uuids, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'middle_name',
        'email',
        'password',
        'phone_number',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $dates = [
        'created_at'
    ];

    public function getRouteKeyName()
    {
        return 'encodedKey';
    }

    protected function password(): Attribute
    {
        return new Attribute(
            set: fn($value) => Hash::make($value)
        );
    }

    public function findForPassport($username)
    {
        return Cache::get($username);
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * Send the welcome email notification.
     *
     * @return void
     */
    public function sendWelcomeEmailNotification()
    {
        $this->notify(new WelcomeNotification);
    }

    /**
     * Send the welcome email notification.
     *
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new PasswordResetNotification($token));
    }

    public function userData(? array $tokenData = [])
    {
        $data["user_info"] = [
            'id'  => $this->encodedKey,
            'first_name'  => $this->first_name,
            'last_name'  => $this->last_name,
            'middle_name'  => $this->middle_name,
            'phone_number'  => $this->phone_number,
            'email' => $this->email,
            'created_at' => $this->created_at
        ];

        if(!empty($tokenData)) {
            $data = array_merge($data, ClafiyaUtil::respondWithToken($tokenData));
        }

        return $data;
    }
}
