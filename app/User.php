<?php

namespace App;
  
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Passport\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
  
class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email','mobile_number', 'password',
    ];
  
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'mobile_number_verified_at' => 'datetime',
    ];

    public function hasVerifiedMobileNumber()
    {
        return ! is_null($this->mobile_number_verified_at);
    }

    public function markMobileNumberAsVerified()
    {
        return $this->forceFill([
            'mobile_number_verified_at' => $this->freshTimestamp(),
        ])->save();
    }
}