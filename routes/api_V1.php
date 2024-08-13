<?php

use App\Http\Controllers\Api\V1\AuthorTicketController;
use App\Http\Controllers\Api\V1\ticketController;
use App\Http\Controllers\Api\V1\Authorcontroller;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;



Route::get('/ticket',[ticketController::class,'index'])->middleware('auth:sanctum')->name('ticket.index');
Route::post('/ticket',[ticketController::class,'store'])->middleware('auth:sanctum')->name('ticket.store');
Route::get('/ticket/{ticket}',[ticketController::class,'show'])->middleware('auth:sanctum')->name('ticket.show');
Route::delete('/ticket/{ticket}',[ticketController::class,'destroy'])->middleware('auth:sanctum')->name('ticket.delete');
Route::put('/ticket/{ticketid}',[ticketController::class,'replace'])->middleware('auth:sanctum')->name('ticket.put');
Route::patch('/ticket/{ticketid}',[ticketController::class,'update'])->middleware('auth:sanctum')->name('ticket.patch');

Route::get('/author',[Authorcontroller::class,'index'])->middleware('auth:sanctum')->name('author.index');
Route::middleware('auth:sanctum')->get('/author/{author}',[Authorcontroller::class,'show'])->name('author.show');

Route::get('/author/{user}/tickets',[AuthorTicketController::class,'index'])->middleware('auth:sanctum')->name('authorticket.index');
Route::post('/author/{user}/tickets',[AuthorTicketController::class,'store'])->middleware('auth:sanctum')->name('authorticket.store');
Route::put('/author/{userid}/tickets/{ticketid}',[AuthorTicketController::class,'replace'])->middleware('auth:sanctum')->name('authorticket.put');
Route::patch('/author/{userid}/tickets/{ticketid}',[AuthorTicketController::class,'update'])->middleware('auth:sanctum')->name('authorticket.patch');
Route::delete('/author/{user}/tickets/{ticket}',[AuthorTicketController::class,'destroy'])->middleware('auth:sanctum')->name('authorticket.delete');





Route::get('/user',[UserController::class,'index'])->middleware('auth:sanctum')->name('user.index');
Route::post('/user',[UserController::class,'store'])->middleware('auth:sanctum')->name('user.store');
Route::get('/user/{user}',[UserController::class,'show'])->middleware('auth:sanctum')->name('user.show');
Route::delete('/user/{user}',[UserController::class,'destroy'])->middleware('auth:sanctum')->name('user.delete');
Route::put('/user/{userid}',[UserController::class,'replace'])->middleware('auth:sanctum')->name('user.put');
Route::patch('/user/{userid}',[UserController::class,'update'])->middleware('auth:sanctum')->name('user.patch');







// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
