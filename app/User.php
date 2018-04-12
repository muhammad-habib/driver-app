<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @SWG\Definition(type="object")
 */
class User extends Authenticatable
{
    use Notifiable;


    /**
     * @SWG\Property(format="int64")
     * @var int
     */
    private $id;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $name;

    /**
     * @SWG\Property(format="string")
     * @var string
     */
    private $email;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
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
