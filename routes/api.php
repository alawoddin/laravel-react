<?php

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