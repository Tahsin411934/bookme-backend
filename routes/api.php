<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/property', [PropertyController::class, 'create']);
Route::get('/all', [PropertyController::class, 'index']);


require __DIR__ . '/api/propertySummary.php';
