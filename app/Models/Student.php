<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_code',
        'firstname',
        'lastname',
        'email',
        'password',
        'sector_id'
    ];
    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function accesses()
    {
        return $this->hasMany(ExamAccess::class);
    }
    
    public function profileImage()
    {
        return $this->hasOne(ProfileImage::class, 'user_id', 'student_code');
    }

}
