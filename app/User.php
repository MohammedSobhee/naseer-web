<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use DB;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */


    protected $fillable = [
        'name', 'email', 'password', 'phone', 'verification_code', 'country_code',
        'is_verify', 'gender', 'type', 'city_id', 'gender', 'is_active'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'is_verify' => 'boolean',
        'is_active' => 'boolean',
        'is_completed' => 'boolean',
        'is_edit' => 'boolean',
    ];

    // Set as username any column from users table
    public function findForPassport($username)
    {
        return $this->where(function ($query) use ($username) {
            $query->where('email', $username)->orWhere(DB::raw("CONCAT(`country_code`, `phone`)"), $username);
        })->whereNull('master_id')
            ->first();
    }


    public function City()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function ServiceProvider()
    {
        return $this->hasOne(ServiceProvider::class, 'user_id', 'id')->whereNull('service_providers.master_id');
    }

    public function ServiceProviderTemp()
    {
        return $this->hasOne(ServiceProvider::class, 'user_id', 'master_id')->whereNotNull('service_providers.master_id');
    }

    public function Slave()
    {
        return $this->hasOne(User::class, 'master_id', 'id');
    }

    public function Rates()
    {
        return $this->hasMany(Rate::class, 'user_id', 'id')->where('action','service_provider');
    }

    public function ProviderRates()
    {
        return $this->hasMany(Rate::class, 'service_provider_id', 'id')->where('action','user');
    }

    public function getPhotoAttribute($value)
    {
        return storage_public($value);
    }


}
