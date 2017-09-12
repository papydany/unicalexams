<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class PdgUser extends Authenticatable
{
    use Notifiable;
    protected $guard ="pdg";
    protected $connection = 'mysql2';
   

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname', 'firstname', 'othername','matric_number', 'programme_id','state_id','lga_id', 'email', 'password','entry_year','image_url','gender','nationality','address','phone','marital_status',
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

