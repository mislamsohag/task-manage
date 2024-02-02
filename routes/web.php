<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UsersController;
use App\Http\Middleware\TokenVerificationMiddleware;
use Illuminate\Support\Facades\Route;

//Home Page
Route::get('/', [HomeController::class, 'HomePage']);
Route::get('/home', [HomeController::class, 'HomePage']);

// Authentication Pages View Routes
Route::get('/registrationPage', [UsersController::class, 'RegistrationPage']);
Route::get('/loginPage', [UsersController::class, 'LoginPage']);
Route::get('/sendOTPPage', [UsersController::class, 'SendOTPPage']);
Route::get('/verifyOTPPage', [UsersController::class, 'VerifyOTPPage']);
// Create, Update, Delete
Route::post('/userRegistration', [UsersController::class, 'UserCreate']);
Route::post('/userLogin', [UsersController::class, 'UserLogin']);
Route::post('/sendOTPCode', [UsersController::class, 'SendOTPCode']);
Route::post('/verifyOTP', [UsersController::class, 'VerifyOTP']);
//Logout
Route::get('/logout', [UsersController::class, 'UserLogout']);

// Authorization Protected Routes
Route::post('/resetPassword', [UsersController::class, 'ResetPassword'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/passwordResetPage', [UsersController::class, 'PasswordResetPage'])->middleware([TokenVerificationMiddleware::class]);

// Task Page
Route::get('/taskPage', [TaskController::class, 'TaskPage'])->middleware([TokenVerificationMiddleware::class]);
Route::get('/taskList', [TaskController::class, 'TaskList'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/taskCreate', [TaskController::class, 'TaskCreate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/singleTask', [TaskController::class, 'SingleTask'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/taskUpdate', [TaskController::class, 'TaskUpdate'])->middleware([TokenVerificationMiddleware::class]);
Route::post('/taskDelete', [TaskController::class, 'TaskDelete'])->middleware([TokenVerificationMiddleware::class]);




// Route::get('/dashboard', [UsersController::class, 'DashboardPage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/profilePage', [UsersController::class, 'ProfilePage'])->middleware([TokenVerificationMiddleware::class]);
// Route::get('/userProfile', [UsersController::class, 'UserProfile'])->middleware([TokenVerificationMiddleware::class]);
// Route::post('/profileUpdate', [UsersController::class, 'ProfileUpdate'])->middleware([TokenVerificationMiddleware::class]);



