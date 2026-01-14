<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProjectController;
use App\Http\Controllers\API\TestController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::get('/test' , function(){
//     return response()->json(['message' => 'message from the testing']);
// });

Route::controller(TestController::class)->group(function () {
    Route::get('/test', 'index');
});

Route::apiResource('projects', ProjectController::class)->middleware('auth:sanctum');


Route::apiResource('tasks', ProjectController::class)->middleware('auth:sanctum');

// register
Route::post('/register' , [AuthController::class , 'register']);

// login
Route::post('/login' , [AuthController::class , 'login']);


// logout

Route::post('/logout' , [AuthController::class , 'logout'])->middleware('auth:sanctum');