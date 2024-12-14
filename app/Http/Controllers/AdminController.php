<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PendingUser;
use App\Models\Teacher;
use App\Models\Exam;
use App\Models\Subject;
use App\Models\Sector;
use App\Models\Admin;
use App\Models\Student;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{

    public function home()
    {
        $pendingUsersCount = PendingUser::count();
        $teachersCount = Teacher::count();
        $studentsCount = Student::count();

        return view('admin.home', compact('pendingUsersCount', 'teachersCount', 'studentsCount'));
    }

    public function showTeachers()
    {
        $teachers = Teacher::all();
        return view('admin.showTeachers', compact('teachers'));
    }
    public function showStudents()
    {
        $students = Student::with('sector')->get();
        $sectors = Sector::all();
        return view('admin.showStudents', compact('students', 'sectors'));
    }

    public function searchTeachers(Request $request)
    {
        $query = Teacher::query();

        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('teacher_code', 'like', "%{$search}%")
                    ->orWhere('firstname', 'like', "%{$search}%")
                    ->orWhere('lastname', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $teachers = $query->get();

        return response()->json($teachers);
    }

    public function deleteTeacher($id)
    {
        try {
            $teacher = Teacher::findOrFail($id);

            // Delete related exams and subjects
            Exam::where('teacher_id', $teacher->id)->delete();
            Subject::where('teacher_id', $teacher->id)->delete();

            // Now, delete the teacher
            $teacher->delete();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
    }


    public function searchStudents(Request $request)
    {
        $query = $request->input('search');
        $sectorId = $request->input('sector_id');

        $students = Student::with('sector')
            ->when($query, function ($q) use ($query) {
                $q->where('firstname', 'like', "%{$query}%")
                    ->orWhere('lastname', 'like', "%{$query}%")
                    ->orWhere('email', 'like', "%{$query}%")
                    ->orWhere('student_code', 'like', "%{$query}%");
            })
            ->when($sectorId, function ($q) use ($sectorId) {
                $q->where('sector_id', $sectorId);
            })
            ->get();

        return response()->json($students);
    }

    public function showPendingUsers()
    {
        $pendingUsers = PendingUser::with('sector')->get();
        return view('admin.pending', compact('pendingUsers'));
    }


    public function approveUser($id)
    {
        $pendingUser = PendingUser::findOrFail($id);

        if ($pendingUser->role === 'Student') {
            Student::create([
                'student_code' => $pendingUser->code,
                'firstname' => $pendingUser->firstname,
                'lastname' => $pendingUser->lastname,
                'email' => $pendingUser->email,
                'password' => $pendingUser->password,
                'sector_id' => $pendingUser->sector_id,
            ]);
        } elseif ($pendingUser->role === 'Teacher') {
            Teacher::create([
                'teacher_code' => $pendingUser->code,
                'firstname' => $pendingUser->firstname,
                'lastname' => $pendingUser->lastname,
                'email' => $pendingUser->email,
                'password' => $pendingUser->password,
            ]);
        }

        $pendingUser->delete();

        return redirect()->route('admin.pending-users')->with('success', 'User approved successfully.');
    }

    public function declineUser($id)
    {
        $pendingUser = PendingUser::findOrFail($id);
        $pendingUser->delete();

        return redirect()->route('admin.pending-users')->with('success', 'User declined successfully.');
    }

    public function addForm()
    {
        $sectors = Sector::all();
        return view('admin.addUser', compact('sectors'));
    }

    public function addUser(Request $request)
    {
        $userType = $request->input('type');
        if (is_null($userType)) {
            return redirect()->back()->withErrors(['error' => 'User type is required']);
        }

        // Common validation rules
        $rules = [
            'code' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ];

        // Conditional validation based on user type
        if ($userType == '2') {
            $rules['firstname'] = 'required|string|max:255';
            $rules['lastname'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255|unique:teachers,email';
        }

        if ($userType == '3') {
            $rules['firstname'] = 'required|string|max:255';
            $rules['lastname'] = 'required|string|max:255';
            $rules['email'] = 'required|email|max:255|unique:students,email';
            $rules['sector_id'] = 'required|exists:sectors,id';
        }

        $validatedData = $request->validate($rules);

        // Insert into the appropriate table
        if ($userType == '1') {
            // Create Admin
            Admin::create([
                'admin_code' => $validatedData['code'],
                'password' => bcrypt($validatedData['password']),
            ]);
        } elseif ($userType == '2') {
            // Create Teacher
            Teacher::create([
                'teacher_code' => $validatedData['code'],
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
            ]);
        } elseif ($userType == '3') {
            // Create Student
            Student::create([
                'student_code' => $validatedData['code'],
                'firstname' => $validatedData['firstname'],
                'lastname' => $validatedData['lastname'],
                'email' => $validatedData['email'],
                'password' => bcrypt($validatedData['password']),
                'sector_id' => $validatedData['sector_id'],
            ]);
        }

        return redirect()->back()->with('success', 'User added successfully!');
    }
    public function updateStudent(Request $request, $id)
    {
        $request->validate([
            'student_code' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'sector_id' => 'required|exists:sectors,id'
        ]);

        $student = Student::findOrFail($id);
        $student->student_code = $request->input('student_code');
        $student->firstname = $request->input('firstname');
        $student->lastname = $request->input('lastname');
        $student->email = $request->input('email');
        $student->sector_id = $request->input('sector_id');
        $student->save();

        return response()->json(['success' => true, 'message' => 'Student updated successfully']);
    }


    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return response()->json(['success' => true, 'message' => 'Student deleted successfully']);
    }

    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->teacher_code = $request->teacher_code;
        $teacher->firstname = $request->firstname;
        $teacher->lastname = $request->lastname;
        $teacher->email = $request->email;
        $teacher->save();

        return response()->json(['success' => true, 'message' => 'Teacher updated successfully']);
    }

    public function showTeacherExams($id)
    {
        $teacher = Teacher::findOrFail($id);
        $exams = Exam::where('teacher_id', $teacher->id)->get();

        return view('admin.showExams', compact('exams'));
    }

    public function subjects()
    {
        $subjects = Subject::with(['sector', 'teacher'])->get();
        $sectors = Sector::all();
        $teachers = Teacher::all();
        return view('admin.subjects', compact('subjects', 'sectors', 'teachers'));
    }

    public function searchSubjects(Request $request)
    {
        $query = Subject::with(['sector', 'teacher']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('subject_name', 'LIKE', "%{$search}%");
        }

        if ($request->filled('sector_id')) {
            $query->where('sector_id', $request->input('sector_id'));
        }

        $subjects = $query->get();

        return response()->json($subjects);
    }


    public function updateSubject(Request $request, $id)
    {
        $subject = Subject::findOrFail($id);
        $subject->update($request->all());

        return response()->json(['success' => true]);
    }

    public function deleteSubject($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(['success' => true]);
    }

    public function addSubject(Request $request)
    {
        $subject = new Subject();
        $subject->subject_name = $request->input('subject_name');
        $subject->sector_id = $request->input('sector_id');
        $subject->teacher_id = $request->input('teacher_id');
        $subject->save();

        return response()->json(['success' => true, 'subject' => $subject->load('sector', 'teacher')]);
    }

    public function sectors()
    {
        $sectors = Sector::all();
        return view('admin.sectors', compact('sectors'));
    }

    public function addSector(Request $request)
    {
        $sector = new Sector();
        $sector->sector_name = $request->input('sector_name');
        $sector->save();

        return response()->json(['success' => true, 'sector' => $sector]);
    }

    public function updateSector(Request $request, $id)
    {
        $sector = Sector::find($id);
        $sector->sector_name = $request->input('sector_name');
        $sector->save();

        return response()->json(['success' => true]);
    }

    public function deleteSector($id)
    {
        $sector = Sector::find($id);
        $sector->delete();

        return response()->json(['success' => true]);
    }

    public function searchSectors(Request $request)
    {
        $query = $request->input('search');
        $sectors = Sector::where('sector_name', 'like', "%$query%")->get();

        return response()->json($sectors);
    }


}
