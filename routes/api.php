<?php
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\LocationController;
Route::get('/states', [LocationController::class, 'states']);
Route::get('/states/{state}/cities', [LocationController::class, 'cities']);
Route::get('/cities/{city}/localities', [LocationController::class, 'localities']);
Route::get('/localities/{locality}/societies', [LocationController::class, 'societies']);
