<?php

namespace App;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use  Notifiable;

    protected $connection = 'mysql2';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'surname', 'firstname', 'othername','jamb_reg','matric_number', 'programme_id', 'faculty_id','department_id', 'fos_id', 'state_id','lga_id', 'email', 'password','entry_year','entry_month','student_type','image_url','gender','nationality','address','phone','marital_status',
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
