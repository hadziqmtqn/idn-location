<?php

use App\Http\Controllers\API\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function (){
    Route::get('/provinces', [AddressController::class, 'selectProvince'])->name('address.province-select');
    Route::get('/cities', [AddressController::class, 'selectCity'])->name('address.city-select');
    Route::get('/districts', [AddressController::class, 'selectDistrict'])->name('address.district-select');
    Route::get('/villages', [AddressController::class, 'selectVillage'])->name('address.village-select');
});
