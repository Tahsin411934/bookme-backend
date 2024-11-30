<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\propertySummaryController;
Route::get('/propertySummary', [propertySummaryController::class, 'apiCreate']);
Route::get('/propertyImages/{property_id}', [propertySummaryController::class, 'apiForPropertyImages']);
Route::get('/propertySummary/{property_id}', [propertySummaryController::class, 'apiForPropertySummary']);
Route::get('/propertyfacilities/{property_id}', [propertySummaryController::class, 'apiForPropertyfacilities']);

Route::get('/', function () {
    return response()->json(['message' => 'Successfullay added']);
});