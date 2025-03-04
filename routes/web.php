<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\AddFacilityController;
use App\Http\Controllers\PropertyImageController;
use App\Http\Controllers\PropertySummaryController;
use App\Http\Controllers\PropertyUnitController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\SpotController;
use App\Http\Controllers\ServiceCategoryController;
use App\Http\Controllers\TourConsultationRequestAdminController;

use App\Http\Controllers\ContactAttributeController;


Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('spots', SpotController::class);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



Route::resource('contact-attributes', ContactAttributeController::class);


Route::resource('tour-consultation-requests', TourConsultationRequestAdminController::class);

Route::resource('properties', PropertyController::class);
Route::get('/package/{spot_id}', [PropertyController::class, 'spotwiseProperty'])->name('properties.package');
Route::resource('facilities', AddFacilityController::class);
// Route::resource('property_images', PropertyImageController::class);
Route::get('/property_images/{property_id}', [PropertyImageController::class, 'show'])->name('property_images.show');

Route::post('/property_images', [PropertyImageController::class, 'store'])->name('property_images.store');
Route::delete('/property_images/{image_id}', [PropertyImageController::class, 'destroy'])->name('property_images.destroy');
// Route::resource('AddImages', AddImageController::class);
Route::resource('service_categories', ServiceCategoryController::class);


Route::resource('property-summary', PropertySummaryController::class);
Route::apiResource('property-units', PropertyUnitController::class);
Route::post('/price', [PriceController::class, 'store'])->name('price.store');
Route::resource('discount', DiscountController::class);
require __DIR__.'/auth.php';