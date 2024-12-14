<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileImage extends Model
{
    use HasFactory;

    protected $fillable = ['image_path', 'type', 'user_id'];

    public function student()
    {
        return $this->belongsTo(Student::class, 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'user_id');
    }
}
