<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\StudentManagementController;

Route::post("/register", [AuthController::class, "register"]);
Route::post("/login", [AuthController::class, "login"]);

Route::get('/students', [StudentManagementController::class, 'index']);
Route::get('/students/grades', [StudentManagementController::class, 'grades']);
Route::get('/students/nims', [StudentManagementController::class, 'getNims']);
Route::get('/students/{student}', [StudentManagementController::class, 'show']); // Add this line
Route::post('/students', [StudentManagementController::class, 'store']);
Route::post('/students/grades', [StudentManagementController::class, 'storeGrades']);
Route::put('/students/{student}', [StudentManagementController::class, 'update']);
Route::delete('/students/{student}', [StudentManagementController::class, 'destroy']);

Route::get('/student/{id}', [StudentManagementController::class, 'show']);
Route::get('/grades/{nim}', [StudentManagementController::class, 'getGradesByNim']);
