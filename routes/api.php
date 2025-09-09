<?php

use App\Enum\RoleEnum;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\RegisterController;
use App\Http\Controllers\Api\Academic\GradeController;
use App\Http\Controllers\Api\School\StudentController;
use App\Http\Controllers\Api\School\TeacherController;
use App\Http\Controllers\Api\School\GuardianController;
use App\Http\Controllers\Api\Academic\SectionController;
use App\Http\Controllers\Api\Academic\SubjectController;
use App\Http\Controllers\Api\Academic\EnrollmentController;
use App\Http\Controllers\Api\Academic\AcademicYearController;

Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:sanctum');

Route::group(['middleware' => ['auth:sanctum', 'role.permission:' . RoleEnum::ADMINISTRATOR->value]], function () {
    Route::group(['prefix' => 'student'], function () {
        Route::get('/', [StudentController::class, 'index']);
        Route::post('/create', [StudentController::class, 'store']);
        Route::put('/update/{id}', [StudentController::class, 'update']);
        Route::get('/show/{id}', [StudentController::class, 'show']);
        Route::delete('/delete/{id}', [StudentController::class, 'destroy']);
        Route::get('/onlyTrashed', [StudentController::class, 'onlyTrashed']);
        Route::put('/restore/{id}', [StudentController::class, 'restore']);
    });
    Route::group(['prefix' => 'guardian'], function () {
        Route::post('/create', [GuardianController::class, 'create']);
        Route::put('/update/{student_id}/{guardian_user_id}', [GuardianController::class, 'update']);
    });
    Route::group(['prefix' => 'teacher'], function () {
        Route::post('/create', [TeacherController::class, 'create']);
        Route::put('/update/{id}', [TeacherController::class, 'update']);
    });
    Route::group(['prefix' => 'grade'], function () {
        Route::get('/', [GradeController::class, 'index']);
        Route::post('/create', [GradeController::class, 'store']);
        Route::put('/update/{id}', [GradeController::class, 'update']);
        Route::delete('/delete/{id}', [GradeController::class, 'destroy']);
    });
    Route::group(['prefix' => 'section'], function () {
        Route::post('/create', [SectionController::class, 'store']);
        Route::put('/update/{id}', [SectionController::class, 'update']);
        Route::delete('/delete/{id}', [SectionController::class, 'destroy']);
    });
    Route::group(['prefix' => 'subject'], function () {
        Route::post('/create', [SubjectController::class, 'store']);
        Route::put('/update/{id}', [SubjectController::class, 'update']);
        Route::delete('/delete/{id}', [SubjectController::class, 'destroy']);
    });
    Route::group(['prefix' => 'academic-year'], function () {
        Route::post('/create', [AcademicYearController::class, 'store']);
        Route::put('/update/{id}', [AcademicYearController::class, 'update']);
        Route::delete('/delete/{id}', [AcademicYearController::class, 'destroy']);
    });
    Route::group(['prefix' => 'enrollment'], function () {
        Route::post('/create', [EnrollmentController::class, 'store']);
        Route::put('/update/{id}', [EnrollmentController::class, 'update']);
        Route::delete('/delete/{id}', [EnrollmentController::class, 'destroy']);
    });
});
