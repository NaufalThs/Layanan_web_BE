<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Grade;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class StudentManagementController extends Controller
{
    public function index()
    {
        try {
            $students = Student::with('grades')->get();
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch students data.'], 500);
        }
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:students',
            'username' => 'required|string|max:255|unique:students',
            'password' => 'required|string|min:6',
            'fakultas' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'wali_dosen' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:2000|max:2100',
        ]);

        if ($validator->fails()) {
            Log::error('Validation Errors:', $validator->errors()->toArray());
            return response()->json($validator->errors(), 422);
        }

        try {
            $student = new Student();
            $student->fill($request->all());
            $student->password = bcrypt($request->password);
            $student->save();

            return response()->json(['message' => 'Student created successfully', 'student' => $student], 201);
        } catch (\Exception $e) {
            Log::error('Exception:', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Failed to create student.'], 500);
        }
    }

    public function getNims()
    {
        try {
            $students = Student::select('nim')->get();
            return response()->json($students);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch students data.'], 500);
        }
    }

    public function grades()
    {
        try {
            $grades = Grade::with('student')->get();
            return response()->json($grades);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch grades data.'], 500);
        }
    }

    public function storeGrades(Request $request)
{
    $validator = Validator::make($request->all(), [
        'nim' => 'required|string|max:255|exists:students,nim',
        'matkul' => 'required|string|max:255',
        'nilai' => 'required|integer|min:1|max:4',
    ]);

    if ($validator->fails()) {
        Log::error('Validation Errors:', $validator->errors()->toArray());
        return response()->json($validator->errors(), 422);
    }

    try {
        $student = Student::where('nim', $request->nim)->firstOrFail(); // Ensure correct student is fetched
        $grade = new Grade();
        $grade->student_id = $student->id;
        $grade->matkul = $request->matkul;
        $grade->nilai = $request->nilai;
        $grade->save();

        return response()->json(['message' => 'Grade added successfully', 'grade' => $grade], 201);
    } catch (\Exception $e) {
        Log::error('Exception:', ['error' => $e->getMessage()]);
        return response()->json(['error' => 'Failed to add grade.'], 500);
    }
}

}
