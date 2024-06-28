<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\Student;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:255',
            'nim' => 'required|string|max:255|unique:students',
            'username' => 'required|string|max:255|unique:students',
            'password' => 'required|string|min:6',
            'fakultas' => 'required|string|max:255',
            'program_studi' => 'required|string|max:255',
            'wali_dosen' => 'required|string|max:255',
            'angkatan' => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 401);
        }

        $student = Student::create([
            'nama' => $request->nama,
            'nim' => $request->nim,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'fakultas' => $request->fakultas,
            'program_studi' => $request->program_studi,
            'wali_dosen' => $request->wali_dosen,
            'angkatan' => $request->angkatan
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Student registered successfully',
            'data' => $student
        ], 201);
    }

    public function login(Request $request)
    {
        
            $validateUser = Validator::make($request->all(),
            [
                'username' => 'required|string',
                'password' => 'required|string' // Corrected the validation rule here
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'Validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            
            $student = Student::where('username', $request->username)->first();

            if(!Auth::attempt($request->only(['username', 'password']))){
                return response()->json([
                    'status' => false,
                    'message' => 'username & password tidak sama atau salah'
                    
                ], 401);
            }

            return response()->json([
                'status' => true,
                'message' => 'Login berhasil',
                'token' => $student->createToken("API TOKEN")->plainTextToken
            ], 200);

        
        }

}
