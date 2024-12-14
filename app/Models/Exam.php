<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'start_time',
        'date',
        'end_time',
        'score',
        'type',
        'code_exam',
        'subject_id',
        'teacher_id',
        'score_type',
    ];

    public function subject()
    {
         return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function accesses()
    {
        return $this->hasMany(ExamAccess::class);
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
