<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\AnswerOption;
use Illuminate\View\View;
use App\Models\Option;
use App\Models\Exam;

class QuestionsController extends Controller
{


public function create(): View
    {
        return view('teacher.questions');
    }


public function storeQuestions(Request $request)
    {
        $exam_id = session('exam_id');
        $questions = $request->input('questions');

        foreach ($questions as $questionData) {
    $question = Question::create([
        'txt_question' => $questionData['txt_question'],
        'grade' => $questionData['grade'],
        'exam_id' => $exam_id
    ]);

    foreach ($questionData['options'] as $optionData) {
        $is_correct = isset($optionData['is_correct']) ? $optionData['is_correct'] : false;

        $question->options()->create([
            'txt_option' => $optionData['txt_option'],
            'is_correct' => $is_correct
        ]);
    }
}
         return redirect()->route('teacher')->with('success', 'Questions added successfully');
    }




   public function edit()
    {
    $exam_id = session('exam_id');
    $questions = Question::where('exam_id', $exam_id)->get();

    $exam = Exam::findOrFail($exam_id);

        if($questions->isEmpty()){
            session(['exam_score' => $exam->score]);
            return redirect()->route('questions');
        } else {
            return view('teacher.questionsShow', compact('questions', 'exam'));
    }


    }





    public function update(Request $request)
    {
        $exam_id = $request->input('exam_id');
        $questionsData = $request->input('questions');


        $deletedQuestions = $request->input('deleted_questions', []);
        // Supprimer les questions marquées pour suppression
        foreach ($deletedQuestions as $questionId) {
            Question::findOrFail($questionId)->delete();
        }

        foreach ($questionsData as $key => $questionData) {
            if (strpos($key, 'new_') === false) {
                // Mise à jour de la question existante
                $question = Question::findOrFail($key);
                $question->update([
                    'txt_question' => $questionData['txt_question'],
                    'grade' => $questionData['grade']
                ]);

                // Supprime les anciennes options
                $question->options()->delete();

                // Enregistre les nouvelles options
                foreach ($questionData['options'] as $optionData) {
                    $question->options()->create([
                        'txt_option' => $optionData['txt_option'],
                        'is_correct' => isset($optionData['is_correct']) ? $optionData['is_correct'] : false
                    ]);
                }
            } else {
                // Création d'une nouvelle question
                $question = Question::create([
                    'txt_question' => $questionData['txt_question'],
                    'grade' => $questionData['grade'],
                    'exam_id' => $exam_id
                ]);

                // Enregistre les options
                foreach ($questionData['options'] as $optionData) {
                    $question->options()->create([
                        'txt_option' => $optionData['txt_option'],
                        'is_correct' => isset($optionData['is_correct']) ? $optionData['is_correct'] : false
                    ]);
                }
            }
        }

        return redirect()->route('teacher')->with('success', 'Exam updated successfully');
    }



}
