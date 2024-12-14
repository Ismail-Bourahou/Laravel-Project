<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = [
        'is_correct',
        'exam_id',
        'question_id',
        'option_id',
        'student_id',
    ];
}

