<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::get('/status', [App\Http\Controllers\CotizadorController::class, 'getStatus'])->name('getStatus');

Route::resource('status', App\Http\Controllers\StatusController::class);
Route::resource('gender', App\Http\Controllers\GendersController::class);
Route::get('/salud/cotizacion/{phone}', [App\Http\Controllers\CotizadorController::class, 'getCotizacionByPhone']);

Route::get('/getCotizacionesByOrder/{id}', [App\Http\Controllers\CotizadorController::class, 'getCotizacionesByOrder']);
Route::get('/getCotizacionesByOrder2/', [App\Http\Controllers\CotizadorController::class, 'getCotizacionesByOrder2']);

Route::get('/test', [App\Http\Controllers\CotizadorController::class, 'test']);

Route::get('/frequency', [App\Http\Controllers\CotizadorController::class, 'getFrequency']);
Route::get('/coverages', [App\Http\Controllers\CotizadorController::class, 'getCoberages']);

Route::get('/checkPhone/{number}', [App\Http\Controllers\CotizadorController::class, 'checkPhone']);
Route::get('/verifyCode/{number}/{code}', [App\Http\Controllers\CotizadorController::class, 'verifyCode']);

Route::post('/cotizador/changeMembers/{id}', [App\Http\Controllers\CotizadorController::class, 'changeMembers']);
//Route::get('/getMembersByQuote/{phone}', [App\Http\Controllers\CotizadorSaludController::class, 'getMembersByQuote']);

// New

// Home
Route::get('/getHome', [App\Http\Controllers\HomeController::class, 'getHome']);
// Home

Route::resource("/provinces",App\Http\Controllers\ProvincesController::class);
Route::resource("/codes",App\Http\Controllers\CodesController::class);
Route::post('/cotizarSalud', [App\Http\Controllers\CotizadorSaludController::class, 'cotizarSalud']);
Route::get('/getCotizacionSalud/{phone}', [App\Http\Controllers\CotizadorSaludController::class, 'getCotizacionSalud']);
Route::get('/getQuoteByPhone/{phone}', [App\Http\Controllers\CotizadorSaludController::class, 'getQuoteByPhone']);
Route::post('/sendCotizacion', [App\Http\Controllers\CotizadorSaludController::class, 'sendCotizacion']);
Route::post('/sendCotizacionlotes', [App\Http\Controllers\CotizadorSaludController::class, 'sendCotizacionlotes']);
Route::post('/sendCotizacionlotes2', [App\Http\Controllers\CotizadorSaludController::class, 'sendCotizacionlotes2']);
Route::get('/changeCoverage/{phone}/{coverage}', [App\Http\Controllers\CotizadorSaludController::class, 'changeCoverage']);
Route::post('/changeMembersByQuote', [App\Http\Controllers\CotizadorSaludController::class, 'changeMembersByQuote']);
Route::get('/changeMembersByQuote/{phone}', [App\Http\Controllers\CotizadorSaludController::class, 'getMembersByQuote']);
Route::get('/smtp', [App\Http\Controllers\CotizadorSaludController::class, 'smtp']);
// New

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
