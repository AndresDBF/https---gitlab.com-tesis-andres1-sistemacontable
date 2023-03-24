<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Importexcel;
use App\Http\Controllers\FacturasController;
//use App\Http\Controllers\ClientesController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('clientes','App\Http\Controllers\CustomerController');

/* Route::get('asiento',[AsientoController::class,'index'])->name('asiento'); */


Route::get('groupaccount', [CustomerController::class, 'groupaccount']);
Route::post('subgroupaccount/{idgru}', [CustomerController::class, 'subgroupaccount']);
Route::post('accountname/{idsgr}', [CustomerController::class, 'accountname']);
Route::post('subaccountname/{idgcu}', [CustomerController::class, 'subaccountname']);

Route::get('invoiceing',[FacturasController::class,'createinvoiceing'])->name('invoiceing');
Route::post('invoiceing',[FacturasController::class,'invoiceing'])->name('invoiceing');
Route::get('cinvoiceing',[FacturasController::class,'cinvoiceing'])->name('cinvoiceing');

Route::get('/excel/importar', [Importexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importexcel::class, 'importarexcel'])->name('/excel/importarexcel');

