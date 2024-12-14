<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'accessed_at',
    ];

    // Relation avec le modèle Exam
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    // Relation avec le modèle Student
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
