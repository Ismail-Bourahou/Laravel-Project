<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['txt_question', 'grade', 'exam_id'];

    public function options()
    {
        return $this->hasMany(AnswerOption::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
