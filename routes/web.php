<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
/*
Route::group(['prefix' => 'cotizador'], function () 
{
    
    Route::get('/{route?}/{route2?}/{route3?}/{route4?}', [App\Http\Controllers\CotisegurosController::class, 'index'])->name('home');
});
*/
 Route::group(['prefix' => 'cotizador'], function () {
     Route::get('/auto', [App\Http\Controllers\CotizadorController::class, 'auto'])->name('cotizador.auto');
     Route::get('/hogar', [App\Http\Controllers\CotizadorController::class, 'hogar'])->name('cotizador.hogar');
     Route::get('/salud', [App\Http\Controllers\CotizadorController::class, 'salud'])->name('cotizador.salud');
     Route::post('/salud/cotizacion', [App\Http\Controllers\CotizadorController::class, 'addCotizacion']);
     Route::get('/salud/cotizacion/{phone}', [App\Http\Controllers\CotizadorController::class, 'getCotizacion']);
     Route::get('/salud/cotizacionpersonal/{phone}', [App\Http\Controllers\CotizadorController::class, 'getCotizacion2']);
     Route::get('/cotizacion/exitosa', [App\Http\Controllers\CotizadorController::class, 'cotizacionExitosa']);
     Route::get('/pdf', [App\Http\Controllers\CotizadorController::class, 'pdf']);
 });

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('listado/', [App\Http\Controllers\CotizadorController::class, 'listado'])->name('home');
Route::get('listartabla/', [App\Http\Controllers\CotizadorController::class, 'listartabla'])->name('home');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/excel', [App\Http\Controllers\CotizadorController::class, "insurerExcel" ]);
    Route::post('/excel', [App\Http\Controllers\CotizadorController::class, 'importExcel']);
    
    Route::get('/listar-cotizaciones/{page}', [App\Http\Controllers\CotizadorController::class, "listarCotizaciones" ]);

    Voyager::routes();
});
