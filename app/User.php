<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $table = 'users';
    protected $primaryKey = 'user_id';
    public $timestamps = false;
    protected $fillable = ['user_name', 'email', 'password',
        'user_rank', 'ls_name', 'msn', 'qq', 'mobile_phone', 'country',
        'province', 'city', 'district', 'reg_time', 'last_login',
        'last_ip', 'visit_count','user_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
