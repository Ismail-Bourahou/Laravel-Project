<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\PassedExam;
use App\Models\Student;
use App\Models\Question;
use App\Models\Teacher;
use App\Models\Sector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Str;

class ExamController extends Controller
{


    public function create(): View
    {
        $teacher = Teacher::where('teacher_code', session('user_id'))->first();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        return view('teacher.exam', compact('subjects'));
    }



    public function store(Request $request)
    {

        $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date_format:H:i'],
            'date' => ['required', 'date_format:Y-m-d'],
            'type' => ['required', 'string', 'max:255'],
            'barem_choix' => ['required'],
            'subject_name' => ['required', 'string'],
        ]);



        $subject = Subject::findOrFail($request->input('subject_name'));



        $start_time = $request->input('start_time');
        $end_time = $request->input('end_time');


        // Insert the exam
        $exam = new Exam();
        $exam->title = $request->input('title');
        $exam->start_time = $start_time;
        $exam->date = $request->input('date');
        $exam->end_time = $end_time;
        $exam->score = $request->input('score');

        $type = $request->input('type');
        $options = [
            '1' => 'Canadien System',
            '2' => 'Normal System',
            '3' => 'Multiple Answers',
        ];
        $exam->type = $options[$type];

        $t = $request->input('barem_choix');
        $opts = [
            '1' => 'barem libre',
            '2' => 'barem fix',
        ];
        $exam->score_type = $opts[$t];

        $exam->code_exam = $request->input('code_exam');

        $teacher = Teacher::where('teacher_code', session('user_id'))->first();

        $exam->teacher_id = $teacher->id;
        $exam->subject_id = $subject->id;

        $code = $this->generateUniqueCode();
        $exam->code_exam = $code;

        $exam->save();

        $request->session()->put('exam_id', $exam->id);


        return view('teacher.codeExamPage', compact('exam'));
    }



    public function showProfessorExams()
    {
        $teacher = Teacher::where('teacher_code', session('user_id'))->first();
        $professorId = $teacher->id;
        $exams = Exam::where('teacher_id', $professorId)->get();

        return view('teacher.teacherHome', compact('exams'));
    }




    public function edit(Exam $exam)
    {
        $exam->start_time = Carbon::parse($exam->start_time)->format('H:i');
        $exam->end_time = Carbon::parse($exam->end_time)->format('H:i');

        $teacher = Teacher::where('teacher_code', session('user_id'))->first();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        return view('teacher.examShow', compact('exam', 'subjects'));
    }




    public function update(Request $request, Exam $exam)
    {
        $request->validate([
            'title' => ['required'],
            'start_time' => ['required'],
            'date' => ['required'],
            'end_time' => ['required'],
            'barem_choix' => ['required'],
            'type' => ['required'],
            'subject_name' => ['required'],
        ]);

        $type = $request->input('type');
        $options = [
            '1' => 'Canadien System',
            '2' => 'Normal System',
            '3' => 'Multiple Answers',
        ];
        $typeText = $options[$type];

        $t = $request->input('barem_choix');
        $opts = [
            '1' => 'barem libre',
            '2' => 'barem fix',
        ];
        $type_barem = $opts[$t];

        $exam->update($request->all());

        $exam->type = $typeText;
        $exam->score_type = $type_barem;

        if ($type_barem == "barem libre")
            $exam->score = null;

        $subject = Subject::findOrFail($request->input('subject_name'));
        $exam->subject_id = $subject->id;

        $exam->save();

        session(['exam_id' => $exam->id]);


        return view('teacher.codeExamUpdate', compact('exam'));
    }


    public function generateUniqueCode()
    {
        do {

            $code = Str::random(5);
        } while (Exam::where('code_exam', $code)->exists());

        return $code;
    }


    public function storeCode(Request $request)
    {

        $exam = Exam::where('id', session('exam_id'))->first();
        return redirect()->route('questions')->with('exam_score', $exam->score);
    }

    public function updateCode(Request $request)
    {
        return redirect()->route('questions.edit');
    }


    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return redirect()->route('teacher')->with('success', 'Examen supprimé avec succès');
    }




    
    public function teacherStudents()
    {

        $teacher = Teacher::where('teacher_code', session('user_id'))->first();
        $subjects = Subject::where('teacher_id', $teacher->id)->get();
        $sectorIds = $subjects->pluck('sector_id')->unique();
        $students = Student::whereIn('sector_id', $sectorIds)->get();

        return view('teacher.teacherStudents', compact('students'));
    }




    public function voirApercu($exam_id)
    {
        $questions = Question::where('exam_id', $exam_id)->get();
        $exam = Exam::find($exam_id);

        return view('teacher.voirApercu', compact('questions', 'exam'));
    }




    public function showPassedExams(Student $student)
    {
        $passedExams = PassedExam::where('student_id', $student->id)->with('exam')->get();

        return view('teacher.studentsPassedExams', compact('student', 'passedExams'));
    }
}
