<?php

use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\AsientoController;
=======
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\Importarexcel;
//use App\Http\Controllers\ClientesController;
>>>>>>> c460ca5a5f5823c6756f45eaaa57e9aec497af78
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

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('clientes','App\Http\Controllers\ClientesController');
<<<<<<< HEAD
Route::get('asiento',[AsientoController::class,'index'])->name('asiento');
=======


Route::get('accounttype', [ClientesController::class, 'tipocuenta']);
Route::post('movementtype/{id}', [ClientesController::class, 'tipomovimiento']);
Route::post('accountname/{id}', [ClientesController::class, 'nombrecuenta']);

Route::get('importar', [Importarexcel::class, 'impportar']);
>>>>>>> c460ca5a5f5823c6756f45eaaa57e9aec497af78
