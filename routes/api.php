<?php

use App\Http\Controllers\API\AddressController;
use App\Http\Controllers\API\V2\CityV2Controller;
use App\Http\Controllers\API\V2\DistrictV2Controller;
use App\Http\Controllers\API\V2\ProvinceV2Controller;
use App\Http\Controllers\API\V2\VillageV2Controller;
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

Route::group(['prefix' => 'v1'], function (){
    Route::get('/provinces', [AddressController::class, 'selectProvince'])->name('address.province-select');
    Route::get('/cities', [AddressController::class, 'selectCity'])->name('address.city-select');
    Route::get('/districts', [AddressController::class, 'selectDistrict'])->name('address.district-select');
    Route::get('/villages', [AddressController::class, 'selectVillage'])->name('address.village-select');
});

Route::group(['prefix' => 'v2'], function () {
    Route::get('/provinces', [ProvinceV2Controller::class, 'index']);
    Route::get('/cities', [CityV2Controller::class, 'index']);
    Route::get('/districts', [DistrictV2Controller::class, 'index']);
    Route::get('/villages', [VillageV2Controller::class, 'index']);
});
