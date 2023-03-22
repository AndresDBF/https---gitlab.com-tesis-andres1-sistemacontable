<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Importarexcel;
//use App\Http\Controllers\ClientesController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('clientes','App\Http\Controllers\CustomerController');

Route::get('asiento',[AsientoController::class,'index'])->name('asiento');


Route::get('groupaccount', [CustomerController::class, 'groupaccount']);
Route::post('subgroupaccount/{idgru}', [CustomerController::class, 'subgroupaccount']);
Route::post('accountname/{idsgr}', [CustomerController::class, 'accountname']);
Route::post('subaccountname/{idgcu}', [CustomerController::class, 'subaccountname']);

Route::get('/excel/importar', [Importarexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importarexcel::class, 'importarexcel'])->name('/excel/importarexcel');

