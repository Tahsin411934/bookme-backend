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
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




Route::resource('properties', PropertyController::class);
Route::resource('facilities', AddFacilityController::class);
// Route::resource('property_images', PropertyImageController::class);
Route::get('/property_images/{property_id}', [PropertyImageController::class, 'show'])->name('property_images.show');

Route::post('/property_images', [PropertyImageController::class, 'store'])->name('property_images.store');
Route::delete('/property_images/{image_id}', [PropertyImageController::class, 'destroy'])->name('property_images.destroy');
// Route::resource('AddImages', AddImageController::class);



Route::resource('property-summary', PropertySummaryController::class);
Route::apiResource('property-units', PropertyUnitController::class);
Route::post('/price', [PriceController::class, 'store'])->name('price.store');
Route::resource('discount', DiscountController::class);
require __DIR__.'/auth.php';