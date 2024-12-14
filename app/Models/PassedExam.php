<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PassedExam extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_id',
        'student_id',
        'grade',
        'score',
        'is_approved',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
}
