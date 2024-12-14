<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Exam;
use App\Models\Question;
use App\Models\PassedExam;
use App\Models\StudentAnswer;
use App\Models\ExamAccess;
use App\Models\AnswerOption;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function create(): View
    {
        $student_code = session()->get('user_id');
        $student = Student::where('student_code', $student_code)->first();
        $sector = $student->sector_id;
        $subjects = Subject::where('sector_id', $sector)->get();
        return view('student.student', compact('subjects'));
    }


    public function showExams($subject_id)
    {
        $today = Carbon::today(); // Obtenir la date d'aujourd'hui
        $exams = Exam::where('subject_id', $subject_id)
            ->whereDate('date','<=', $today) // Ajouter la condition de la date d'aujourd'hui
            ->get();
        return view('student.studentExams', compact('exams'));
    }


    public function showExamCodeForm($exam_id)
{
    return view('student.saisirCode', compact('exam_id'));
}

public function validateStudentCode(Request $request)
{
    $request->validate([
        'code' => 'required|string'
    ]);

    $exam_id = $request->input('exam_id');
    $exam = Exam::where('id', $exam_id)
                ->where('code_exam', $request->input('code'))
                ->first();

    if ($exam) {
        // If the exam code is valid, redirect to the passing method
        return $this->passing($exam->id);
    } else {
        // If the exam code is invalid, redirect back with an error message
        return redirect()->back()->with('status', 'Invalid exam code. Please try again.');
    }
}

public function passing($exam_id)
{
    $questions = Question::where('exam_id', $exam_id)->get();
    $exam = Exam::find($exam_id);

    $currentDateTime = Carbon::now()->addHour();
    $currentDate = $currentDateTime->format('Y-m-d');
    $examEndTime = $currentDate . ' ' . $exam->end_time;

    $student_code = session()->get('user_id');
    $student = Student::where('student_code', $student_code)->first();
    $access = ExamAccess::where('student_id', $student->id)->where('exam_id', $exam->id)->first();

    if ($access) {
        return redirect()->back()->with('status', 'You have already accessed this exam.');
    }

    // Log the student's access to the exam
    ExamAccess::create([
        'student_id' => $student->id,
        'exam_id' => $exam->id,
        'accessed_at' => $currentDateTime,
    ]);

    return view('student.passingPage', compact('questions', 'exam', 'examEndTime'));
}



    public function save(Request $request)
{
    $student_code = session()->get('user_id');
    $student_id = Student::where('student_code', $student_code)->value('id');

    $total_grade = 0;
    $exam_id = $request->input('exam_id');
    $exam = Exam::find($exam_id);

    // Determine if the exam has a fixed score or not
    $fixed_score = $exam->score; // Assuming 'score' field is used to determine fixed score

    $barem = $fixed_score;
    if (!$fixed_score) {
        // Calculate the sum of grades for all questions in the exam
        $barem = Question::where('exam_id', $exam_id)->sum('grade');
    }

    DB::transaction(function () use ($request, $student_id, &$total_grade, $fixed_score, $exam, $barem) {
        $questions = $request->input('questions', []);
        $total_questions = count($questions);

        foreach ($questions as $questionData) {
            $question_id = $questionData['question_id'];
            $selected_options = $questionData['options'] ?? [];

            $correct_options = AnswerOption::where('question_id', $question_id)
                ->where('is_correct', true)
                ->pluck('id')
                ->toArray();

            // Grade for the question based on fixed score
            $question = Question::find($question_id);
            $question_grade = $fixed_score ? ($exam->score / $total_questions) : $question->grade;

            foreach ($selected_options as $option_id) {
                $is_correct = in_array($option_id, $correct_options);
                StudentAnswer::create([
                    'exam_id' => $request->input('exam_id'),
                    'question_id' => $question_id,
                    'option_id' => $option_id,
                    'student_id' => $student_id,
                    'is_correct' => $is_correct,
                ]);
            }

            $all_correct_selected = !array_diff($correct_options, $selected_options);
            $no_incorrect_selected = !array_diff($selected_options, $correct_options);

            if ($exam->type == 'Canadien System') {
                // Penalize for incorrect answers in Canadian system
                if ($all_correct_selected && $no_incorrect_selected) {
                    $total_grade += $question_grade;
                } else {
                    // Assuming penalty is half the question grade for incorrect answers
                    $total_grade -= ($question_grade);
                }
            } else {
                // Normal system grading
                if ($all_correct_selected && $no_incorrect_selected) {
                    $total_grade += $question_grade;
                }
            }
        }

        // Ensure total_grade doesn't go below 0
        $total_grade = max(0, $total_grade);

        PassedExam::create([
            'exam_id' => $request->input('exam_id'),
            'student_id' => $student_id,
            'grade' => $total_grade,
            'score' => $barem,
        ]);
    });

    return view('student.resultat');
}





    public function showExamDetails($examId)
    {
        // Retrieve list of students who passed the exam with their full names
        $passedStudents = Student::join('passed_exams', 'students.id', '=', 'passed_exams.student_id')
            ->where('passed_exams.exam_id', $examId)
            ->selectRaw('students.id, CONCAT(firstname, " ", lastname) AS full_name , grade , score , exam_id ,is_approved')
            ->get();

            $isApproved = $passedStudents->first()->is_approved ?? false;

            return view('teacher.passedStudents', ['passedStudents' => $passedStudents, 'exam_id' => $examId, 'isApproved' => $isApproved]);
    }

    public function approveDisplayingGrades($exam_id)
    {
        PassedExam::where('exam_id', $exam_id)->update(['is_approved' => true]);
        return redirect()->back()->with('status', 'Les résultats ont été approuvés.');
    }



    public function nonePassed($examId)
    {
        $studentsWithAccess = Student::join('exam_accesses', 'students.id', '=', 'exam_accesses.student_id')
            ->where('exam_accesses.exam_id', $examId)
            ->leftJoin('passed_exams', function ($join) use ($examId) {
                $join->on('students.id', '=', 'passed_exams.student_id')
                     ->where('passed_exams.exam_id', $examId);
            })
            ->whereNull('passed_exams.id')
            ->select('students.id', 'students.firstname', 'students.lastname')
            ->get();

        return view('teacher.nonePassedStudents', ['students' => $studentsWithAccess, 'exam_id' => $examId]);
    }





    public function showStudentExamDetails($examId, $studentId)
    {
        // Récupérer l'examen, les questions et les réponses de l'étudiant
        $exam = Exam::findOrFail($examId);
        $questions = Question::where('exam_id', $examId)->get();
        $studentAnswers = StudentAnswer::where('exam_id', $examId)
            ->where('student_id', $studentId)
            ->get()
            ->groupBy('question_id');

        $student = Student::where('id', $studentId)->first();

        // Passer les données à la vue
        return view('teacher.studentExamDetails', [
            'exam' => $exam,
            'questions' => $questions,
            'studentAnswers' => $studentAnswers,
            'student' => $student
        ]);
    }


    public function studentExamGrade($exam_id)
    {
        $student_code = session()->get('user_id');
        $student = Student::where('student_code', $student_code)->first();
        $passedExams = PassedExam::where('student_id', $student->id)
            ->where('is_approved', true)
            ->where('exam_id',$exam_id)
            ->get();

        return view('student.studentExamGrade', compact('passedExams'));
    }

}
