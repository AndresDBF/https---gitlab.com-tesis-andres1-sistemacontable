<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\Importarexcel;
//use App\Http\Controllers\ClientesController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('clientes','App\Http\Controllers\ClientesController');

Route::get('asiento',[AsientoController::class,'index'])->name('asiento');


Route::get('accounttype', [ClientesController::class, 'tipocuenta']);
Route::post('movementtype/{id}', [ClientesController::class, 'tipomovimiento']);
Route::post('accountname/{id}', [ClientesController::class, 'nombrecuenta']);

Route::get('/excel/importar', [Importarexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importarexcel::class, 'importarexcel'])->name('/excel/importarexcel');

