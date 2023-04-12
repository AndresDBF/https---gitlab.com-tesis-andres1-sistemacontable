<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Importexcel;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ComprIngController;
//use App\Http\Controllers\ClientesController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//clientes
Route::resource('clientes','App\Http\Controllers\CustomerController');
Route::get('groupaccount', [CustomerController::class, 'groupaccount']);
Route::post('subgroupaccount/{idgru}', [CustomerController::class, 'subgroupaccount']);
Route::post('accountname/{idsgr}', [CustomerController::class, 'accountname']);
Route::post('subaccountname/{idgcu}', [CustomerController::class, 'subaccountname']);

//Facturas de ingreso
Route::get('createinvoiceing',[FacturasController::class,'createinvoiceing'])->name('createinvoiceing');
Route::post('storeinvoiceing',[FacturasController::class,'storeinvoiceing'])->name('storeinvoiceing');
Route::get('createdetinvoiceing/{numConcept}',[FacturasController::class,'createdetinvoiceing'])->name('createdetinvoiceing');
Route::post('storedetinvoiceing',[FacturasController::class,'storedetinvoiceing'])->name('storedetinvoiceing');
Route::get('totalinvoice/{idfact}',[FacturasController::class,'totalinvoice'])->name('totalinvoice');

//Comprobante de ingreso
Route::get('createing',[ComprIngController::class,'findInvoice'])->name('createing');
Route::get('getIdentification/{tipid}/{identification}/{numcheck}',[ComprIngController::class,'getIdentification'])->name('getIdentification');

Route::get('/excel/importar', [Importexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importexcel::class, 'importarexcel'])->name('/excel/importarexcel');

