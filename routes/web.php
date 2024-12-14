<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\MatiereController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AccountController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/error', function () {
    return view('error');
})->name('error');

Route::get('signup', [SignupController::class, 'create'])->name('signup');

Route::post('signup/student', [SignupController::class, 'storeStudent'])->name('signup.s');

Route::post('signup/teacher', [SignupController::class, 'storeTeacher'])->name('signup.t');

Route::get('login', [LoginController::class, 'create'])->name('login');

Route::post('login', [LoginController::class, 'authenticate'])->name('login');


Route::middleware(['check.auth'])->group(function () {

    Route::get('/student', [StudentController::class, 'create'])->name('student');

    Route::get('/student/exams/{subject_id}', [StudentController::class, 'showExams'])->name('showExams');

    Route::get('/student/{exam_id}', [StudentController::class, 'passing'])->name('passing');

    Route::post('/student/exams/pass', [StudentController::class, 'save'])->name('saveExamResponses');

    Route::get('/enter-exam-code/{exam_id}', [StudentController::class, 'showExamCodeForm'])->name('enter.exam.code');

    Route::post('/validate-exam-code', [StudentController::class, 'validateStudentCode'])->name('validate.exam.code');

    Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');

    Route::get('/account', [AccountController::class, 'show'])->name('account.show');

    Route::post('/account/upload-image', [AccountController::class, 'uploadImage'])->name('profile.uploadImage');

    Route::get('/exam/{examId}/student/{studentId}', [StudentController::class, 'showStudentExamDetails'])->name('exam.student.details');

    Route::get('/examGrade/{exam_id}', [StudentController::class, 'studentExamGrade'])->name('studentExamGrade');

    Route::get('/account/change-password', [AccountController::class, 'changePassword'])->name('change.password');

    Route::post('/change-password', [AccountController::class, 'newPassword'])->name('new.password');


    Route::middleware(['verify.admin'])->group(function () {

        Route::get('/admin/home', [AdminController::class, 'home'])->name('admin.home');

        Route::get('/admin/teachers', [AdminController::class, 'showTeachers'])->name('admin.showTeachers');

        Route::get('/admin/students', [AdminController::class, 'showStudents'])->name('admin.showStudents');

        Route::get('/admin/teachers/search', [AdminController::class, 'searchTeachers'])->name('admin.searchTeachers');

        Route::get('/admin/students/search', [AdminController::class, 'searchStudents'])->name('admin.searchStudents');

        Route::get('/admin/pending-users', [AdminController::class, 'showPendingUsers'])->name('admin.pending-users');

        Route::post('/admin/pending-users/{id}/approve', [AdminController::class, 'approveUser'])->name('admin.approve-user');

        Route::post('/admin/pending-users/{id}/decline', [AdminController::class, 'declineUser'])->name('admin.decline-user');

        Route::get('/admin/add-user', [AdminController::class, 'addForm'])->name('admin.add-form');

        Route::post('/admin/added-user', [AdminController::class, 'addUser'])->name('admin.add-user');

        Route::delete('/admin/students/{id}', [AdminController::class, 'deleteStudent']);

        Route::put('/admin/students/{id}', [AdminController::class, 'updateStudent']);

        Route::put('/admin/teachers/{id}', [AdminController::class, 'updateTeacher']);

        // In your routes file, make sure this is correctly defined
        Route::delete('/admin/teachers/{id}', [AdminController::class, 'deleteTeacher']);


        Route::get('/admin/teachers/{id}/exams', [AdminController::class, 'showTeacherExams']);

        Route::get('/exams/{examId}', [StudentController::class, 'showExamDetails'])->name('exam.detail');

        Route::get('/show/exam/{examId}', [ExamController::class, 'voirApercu'])->name('voirAp');

        Route::get('/admin/subjects', [AdminController::class, 'subjects'])->name('admin.subjects');

        Route::get('/admin/subjects/search', [AdminController::class, 'searchSubjects']);

        Route::put('/admin/subjects/{id}', [AdminController::class, 'updateSubject']);

        Route::delete('/admin/subjects/{id}', [AdminController::class, 'deleteSubject']);

        Route::post('/admin/subjects', [AdminController::class, 'addSubject'])->name('admin.add-subject');

        Route::get('/admin/sectors', [AdminController::class, 'sectors'])->name('admin.sectors');

        Route::post('/admin/sectors', [AdminController::class, 'addSector'])->name('admin.add-sector');

        Route::put('/admin/sectors/{id}', [AdminController::class, 'updateSector']);

        Route::delete('/admin/sectors/{id}', [AdminController::class, 'deleteSector']);

        Route::get('/admin/sectors/search', [AdminController::class, 'searchSectors']);

    });


    Route::middleware(['verify.teacher'])->group(function () {

        Route::get('/teacher', [ExamController::class, 'showProfessorExams'])->name('teacher');

        Route::get('/teacher/exam/create', [ExamController::class, 'create'])->name('exam');

        Route::post('/teacher/exam/create', [ExamController::class, 'store'])->name('exam');

        Route::get('/teacher/exam/questions', [QuestionsController::class, 'create'])->name('questions');

        Route::post('/teacher/exam/questions', [QuestionsController::class, 'storeQuestions'])->name('questions.store');

        Route::get('/matieres-by-filiere/{filiereId}', [MatiereController::class, 'getMatieresByFiliere']);

        Route::get('/teacher/exam/{exam}/edit', [ExamController::class, 'edit'])->name('exam.edit');

        Route::post('/teacher/exam/{exam}', [ExamController::class, 'update'])->name('exam.update');

        Route::get('/teacher/questions/edit', [QuestionsController::class, 'edit'])->name('questions.edit');

        Route::post('/teacher/questions/update', [QuestionsController::class, 'update'])->name('updateQuestions');

        Route::delete('/delete-question/{questionId}', [QuestionsController::class, 'deleteQuestion'])->name('questions.delete');

        Route::get('/exam/{examId}', [StudentController::class, 'showExamDetails'])->name('exam.details');

        Route::get('/show/{examId}', [ExamController::class, 'voirApercu'])->name('voirApercu');

        Route::post('/code', [ExamController::class, 'storeCode'])->name('code.create');

        Route::post('/codeUpdate', [ExamController::class, 'updateCode'])->name('code.update');

        Route::delete('/exam/{exam}', [ExamController::class, 'destroy'])->name('exam.destroy');

        Route::get('/students', [ExamController::class, 'teacherStudents'])->name('teacherStudents');

        Route::get('/students/{student}/passed-exams', [ExamController::class, 'showPassedExams'])->name('students.passedExams');

        Route::post('/approveDisplayingGrades/{exam_id}', [StudentController::class, 'approveDisplayingGrades'])->name('approveDisplayingGrades');
        Route::get('/none_passed_students/{exam_id}', [StudentController::class, 'nonePassed'])->name('nonePassed');
    });



});



