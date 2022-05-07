<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_active',
        'settings',
        'settings->general->company_name',
        'settings->general->company_address',
        'settings->support->company_mobile',
        'settings->support->company_email',
        'settings->email->company_mail_mailer',
        'settings->email->company_mail_host',
        'settings->email->company_mail_port',
        'settings->email->company_mail_username',
        'settings->email->company_mail_password',
        'settings->email->company_mail_encryption',
        'settings->email->company_mail_from_address',
        'settings->email->company_mail_from_name',
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
        'settings' => 'json',
    ];

    public function userDetails()
    {
        return $this->hasOne(UserDetail::class);
    }

    public function clientDetails()
    {
        return $this->hasOne(ClientDetails::class);
    }

    public function state()
    {
        return $this->hasOne(State::class);
    }

    public function city()
    {
        return $this->hasOne(City::class);
    }

    public function designation()
    {
        return $this->hasOne(Designation::class);
    }

    public function gstProfile()
    {
        return $this->hasOne(GstProfile::class);
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
