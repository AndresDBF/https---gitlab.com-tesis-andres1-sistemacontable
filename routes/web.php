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
//profile
Route::get('/profile', 'ProfileController@show')->name('profile.show');

//clientes
Route::resource('clientes','App\Http\Controllers\CustomerController');
Route::get('groupaccount1', [CustomerController::class, 'groupaccount1']);
Route::post('subgroupaccount1/{idgru}', [CustomerController::class, 'subgroupaccount1']);
Route::post('accountname1/{idsgr}', [CustomerController::class, 'accountname1']);
Route::post('subaccountname1/{idgcu}', [CustomerController::class, 'subaccountname1']);
Route::get('groupaccount2', [CustomerController::class, 'groupaccount2']);
Route::post('subgroupaccount2/{idgru}', [CustomerController::class, 'subgroupaccount2']);
Route::post('accountname2/{idsgr}', [CustomerController::class, 'accountname2']);
Route::post('subaccountname2/{idgcu}', [CustomerController::class, 'subaccountname2']);

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
Route::get('groupaccount1', [IncomeController::class, 'groupaccount1']);
Route::post('subgroupaccount1/{idgru}', [IncomeController::class, 'subgroupaccount1']);
Route::post('accountname1/{idsgr}', [IncomeController::class, 'accountname1']);
Route::post('subaccountname1/{idgcu}', [IncomeController::class, 'subaccountname1']);
Route::get('groupaccount2', [IncomeController::class, 'groupaccount2']);
Route::post('subgroupaccount2/{idgru}', [IncomeController::class, 'subgroupaccount2']);
Route::post('accountname2/{idsgr}', [IncomeController::class, 'accountname2']);
Route::post('subaccountname2/{idgcu}', [IncomeController::class, 'subaccountname2']);

//Proveedores
Route::resource('supplier','App\Http\Controllers\SupplierController');

Route::get('/excel/importar', [Importexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importexcel::class, 'importarexcel'])->name('/excel/importarexcel');

