<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Traits\HasPermissionsTrait;
use App\Traits\Userstamps;
use App\Events\UserCreated;

class User extends Authenticatable
{
    use Notifiable, HasPermissionsTrait, Userstamps;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'verified',
        'verified_at',
        'active',
        'last_login_at',
        'last_login_ip',
    ];

    /**
     * The attributes that
     *  should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'verified_at',
        'last_login_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        // 'verified' => 'boolean',
        // 'active' => 'boolean',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be searchable.
     *
     * @var array
     */
    protected $searchable = [
        'name',
        'email'
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => UserCreated::class
    ];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = title_case($value);
    }

    public function verifyUser()
    {
        return $this->hasOne('App\VerifyUser');
    }

    public function logins()
    {
        return $this->hasMany('App\Login');
    }

    /**
     * Get the attributes that should be searchable.
     *
     * @return  array
     */
    public function getSearchable()
    {
        return $this->searchable;
    }

    /**
     * Set the attributes that should be searchable.
     *
     * @param  array  $searchable  The attributes that should be searchable.
     *
     * @return  self
     */
    public function setSearchable(array $searchable)
    {
        $this->searchable = $searchable;
        return $this;
    }

    public function getLastLoginAtAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::parse($value)->diffForHumans() . ' ' . $value;
        }
    }
}
