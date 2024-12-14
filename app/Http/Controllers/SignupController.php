<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\Student;
use App\Models\Sector;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use App\Models\PendingUser;

class SignupController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        $sectors = Sector::all();
        return view('signup', compact('sectors'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */

    public function storeTeacher(Request $request)
    {
        $request->validate([
            'teacher_code' => ['required', 'string', 'max:10', 'unique:pending_users,code'],
            'firstname' => ['required', 'string', 'max:30'],
            'lastname' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pending_users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        PendingUser::create([
            'code' => $request->teacher_code,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Teacher',
        ]);

        return redirect()->route('home')->with('success', 'Your registration is pending admin approval.');
    }

    public function storeStudent(Request $request)
    {
        $request->validate([
            'student_code' => ['required', 'string', 'max:10', 'unique:pending_users,code'],
            'firstname' => ['required', 'string', 'max:30'],
            'lastname' => ['required', 'string', 'max:30'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:pending_users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'sector_id' => ['required', 'exists:sectors,id'],
        ]);
        // dd($request->sector_id);
        PendingUser::create([
            'code' => $request->student_code,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'Student',
            'sector_id' => $request->sector_id,
        ]);

        return redirect()->route('home')->with('success', 'Your registration is pending admin approval.');
    }
}
