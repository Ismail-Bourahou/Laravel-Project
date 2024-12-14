<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerOption extends Model
{
    use HasFactory;

    protected $fillable = ['txt_option', 'is_correct', 'question_id'];

    
    protected $table = 'answer_options';

      public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
