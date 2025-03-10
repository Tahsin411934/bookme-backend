<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\TourConsultationRequestController;
use App\Http\Controllers\Api\ContactAttributeController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/property', [PropertyController::class, 'create']);
Route::get('/all', [PropertyController::class, 'index']);
Route::apiResource('tour-consultations', TourConsultationRequestController::class);
Route::apiResource('contact-attributes', ContactAttributeController::class);
use App\Http\Controllers\FooterController;

Route::apiResource('footers', FooterController::class);

use App\Http\Controllers\FooterPolicyController;

Route::apiResource('footer-policies', FooterPolicyController::class);


require __DIR__ . '/api/propertySummary.php';
