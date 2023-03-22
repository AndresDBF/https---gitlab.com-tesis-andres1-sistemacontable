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
Route::resource('clientes','App\Http\Controllers\CustomerController');

Route::get('asiento',[AsientoController::class,'index'])->name('asiento');


<<<<<<< HEAD
Route::get('groupaccount', [CustomerController::class, 'groupaccount']);
Route::post('subgroupaccount/{idgru}', [CustomerController::class, 'subgroupaccount']);
Route::post('accountname/{idsgr}', [CustomerController::class, 'accountname']);
Route::post('subaccountname/{idgcu}', [CustomerController::class, 'subaccountname']);
=======
Route::get('groupaccount', [ClientesController::class, 'groupaccount']);
Route::post('subgroupaccount/{idsgr}', [ClientesController::class, 'subgroupaccount']);
Route::post('accountname/{idgcu}', [ClientesController::class, 'accountname']);
>>>>>>> 4a51ac9c67a34874a99c2b62bd7b65a48004bf06

Route::get('/excel/importar', [Importarexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importarexcel::class, 'importarexcel'])->name('/excel/importarexcel');

