<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'subject_name',
        'sector_id',
        'teacher_id',
    ];
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
