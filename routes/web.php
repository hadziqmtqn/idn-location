<?php

use App\Http\Controllers\API\V2\CityV2Controller;
use App\Http\Controllers\API\V2\ProvinceV2Controller;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'index'])->name('home.index');

Route::group(['prefix' => 'provinces'], function () {
    Route::get('/{indonesiaProvince:code}', [ProvinceV2Controller::class, 'show'])->name('province-v2.show');
    Route::post('/store', [ProvinceV2Controller::class, 'store'])->name('province-v2.store');
});

Route::group(['prefix' => 'cities'], function () {
    Route::get('/{indonesiaCity:code}', [CityV2Controller::class, 'show'])->name('city-v2.show');
    Route::post('/store', [CityV2Controller::class, 'store'])->name('city-v2.store');
});
