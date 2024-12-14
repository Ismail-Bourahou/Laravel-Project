<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Teacher extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'teacher_code',
        'firstname',
        'lastname',
        'email',
        'password',
    ];

    public function profileImage()
    {
        return $this->hasOne(ProfileImage::class, 'user_id', 'teacher_code');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

}
