<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Returns the user's first name
     *
     * @return String
     */
    public function firstName()
    {
        return explode(" ", $this->name)[0];
    }

    /**
     * Returns the user's last names
     *
     * @return String
     */
    public function lastNames()
    {
        return explode(" ", $this->name, 2)[1];
    }

    /**
     * Returns the user's role.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function role()
    {
        return $this->hasOne(UserRole::class, 'id', 'role_id');
    }

    /**
     * Returns a conditional based on whether the user is an administrator or not.
     *
     * @return bool
     */
    public function isAdmin()
    {
         return ($this->role->role === 'admin');
    }
}
