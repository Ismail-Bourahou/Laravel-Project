<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\Student;
use App\Models\ProfileImage;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{

    public function show()
    {
        $userId = Session::get('user_id');

        if (!$userId) {
            return redirect()->route('login')->with('error', 'Please log in first.');
        }

        $teacher = Teacher::with('profileImage')->where('teacher_code', $userId)->first();
        if ($teacher) {
            Log::info('Teacher profile image path: ' . optional($teacher->profileImage)->image_path);
            return view('account', ['user' => $teacher, 'type' => 'teacher']);
        }

        $student = Student::with('sector', 'profileImage')->where('student_code', $userId)->first();
        if ($student) {
            Log::info('Student profile image path: ' . optional($student->profileImage)->image_path);
            return view('account', ['user' => $student, 'type' => 'student']);
        }

        return view('error');
    }




    public function uploadImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|max:2048',
        ]);

        $userId = Session::get('user_id');
        $userType = Teacher::where('teacher_code', $userId)->exists() ? 'teacher' : 'student';

        if (!$userId) {
            return response()->json(['success' => false, 'message' => 'User not logged in.']);
        }

        $path = $request->file('profile_image')->store('profile_images', 'public');

        Log::info('Uploaded image path: ' . $path);

        $profileImage = ProfileImage::updateOrCreate(
            [
                'user_id' => $userId,
                'type' => $userType,
            ],
            ['image_path' => $path]
        );

        return response()->json(['success' => true]);
    }

    public function changePassword()
    {
        return view('changePassword');
    }

    public function newPassword(Request $request)
    {
        // Validate the input
        $request->validate([
            'password' => 'required',
            'new-password' => 'required|min:8',
            'confirm-password' => 'required|same:new-password',
        ]);

        $userId = Session::get('user_id');

        // Try to find the teacher
        $teacher = Teacher::where('teacher_code', $userId)->first();
        if ($teacher) {
            if (!Hash::check($request->input('password'), $teacher->password)) {
                return redirect()->back()->withErrors(['auth' => 'Current password is incorrect']);
            }

            // Change the password
            $teacher->password = Hash::make($request->input('new-password'));
            $teacher->save();

            // Redirect with success message
            return redirect()->back()->with('status', 'Password changed successfully');
        }

        // Try to find the student
        $student = Student::where('student_code', $userId)->first();
        if ($student) {
            if (!Hash::check($request->input('password'), $student->password)) {
                return redirect()->back()->withErrors(['auth' => 'Current password is incorrect']);
            }

            // Change the password
            $student->password = Hash::make($request->input('new-password'));
            $student->save();

            // Redirect with success message
            return redirect()->back()->with('status', 'Password changed successfully');
        }

        // If neither teacher nor student found
        return redirect()->back()->withErrors(['auth' => 'User not found']);
    }


}
