<?php

use App\Http\Controllers\AddUserController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\testController;
use App\Http\Resources\UserCollection;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

Route::get('/', [testController::class,'index']);

Route::get('/about',[testController::class,'show'])->middleware(['auth','isitGmail']);

Route::get('/register',[RegisterController::class,'index'])->name('register')->middleware('guest');
Route::post('/register',[RegisterController::class,'store'])->name('register.store')->middleware('guest');


Route::get('/session',[SessionController::class,'index'])->name('login')->middleware('guest');
Route::post('/session',[SessionController::class,'store'])->name('login.store')->middleware('guest');

Route::delete('/session',[SessionController::class,'destroy'])->name('login.destroy')->middleware('auth');


Route::get('/forgotPassword',[ForgotPasswordController::class,'index'])->name('forgotPassword')->middleware('guest');
Route::post('/forgotPassword',[ForgotPasswordController::class,'store'])->name('forgotPassword.store')->middleware('guest');

Route::get('/resetPassword',[ForgotPasswordController::class,'show'])->name('forgotPassword.show')->middleware('guest');
Route::post('/resetPassword',[ForgotPasswordController::class,'save'])->name('forgotPassword.save')->middleware('guest');

// Route::get('/test',function(){
//     return ( new UserCollection(User::paginate()) );
// });







