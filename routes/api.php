<?php

use App\Http\Controllers\ticket_pleaseController;
use App\Models\V1\ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/',[ticket_pleaseController::class,'index']);
Route::post('/login',[ticket_pleaseController::class,'login']);


Route::middleware('auth:sanctum')->delete('/logout',[ticket_pleaseController::class,'logout']);


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
