<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Admin;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;



class LoginController extends Controller
{
    /**
     * Handle an incoming login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */


    public function create(): View
    {
        return view('login');
    }



    public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'id' => ['required', 'string'],
        'password' => ['required', 'string'],
    ]);

    // Search for the user in the Teacher model
    $teacher = Teacher::where('teacher_code', $request->id)->first();
    if ($teacher && Hash::check($request->password, $teacher->password)) {
        session()->put('user_id', $teacher->teacher_code);
        return redirect()->route('teacher');
    }

    // Search for the user in the Student model
    $student = Student::where('student_code', $request->id)->first();
    if ($student && Hash::check($request->password, $student->password)) {
        session()->put('user_id', $student->student_code);
        return redirect()->route('student');
    }

    // Search for the user in the Admin model
    $admin = Admin::where('admin_code', $request->id)->first();
    if ($admin && Hash::check($request->password, $admin->password)) {
        session()->put('user_id', $admin->admin_code);
        return redirect()->route('admin.home');
    }

    // Authentication failed
    return back()->withErrors(['auth' => 'Invalid ID or password.'])->withInput();
}

}

