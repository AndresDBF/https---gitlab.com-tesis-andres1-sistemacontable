<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Importexcel;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ComprIngController;
use App\Http\Controllers\IncomeController;
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
Route::get('deleteInvoice/{idfact}',[FacturasController::class,'deleteInvoice'])->name('deleteInvoice');

//Comprobante de ingreso
Route::get('searchInvoice',[ComprIngController::class,'searchInvoice'])->name('searchInvoice');
Route::post('findInvoice',[ComprIngController::class,'findInvoice'])->name('findInvoice');
Route::get('createIncome/{idfact}/{idcli}',[ComprIngController::class,'createIncome'])->name('createIncome');
Route::post('storeproof',[ComprIngController::class,'storeproof'])->name('storeproof');

//Ingreso
Route::get('searchIncome',[IncomeController::class,'searchIncome'])->name('searchIncome');
Route::post('findIncome',[IncomeController::class,'findIncome'])->name('findIncome');
Route::get('createIng/{idfact}/{idcli}',[IncomeController::class,'createIng'])->name('createIng');
Route::post('storeIncome',[IncomeController::class,'storeIncome'])->name('storeIncome');

Route::get('/excel/importar', [Importexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importexcel::class, 'importarexcel'])->name('/excel/importarexcel');

