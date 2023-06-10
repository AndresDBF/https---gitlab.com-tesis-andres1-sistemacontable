<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Importexcel;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ComprIngController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PayOrderController;
use App\Http\Controllers\PayController;
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
Route::get('findcustomer', [FacturasController::class,'index'])->name('findcustomer');
Route::get('createinvoiceing/{idcli}',[FacturasController::class,'createinvoiceing'])->name('createinvoiceing');
Route::post('storeinvoiceing',[FacturasController::class,'storeinvoiceing'])->name('storeinvoiceing');
Route::get('createdetinvoiceing/{numConcept}/{idcli}/{tasa_cambio}',[FacturasController::class,'createdetinvoiceing'])->name('createdetinvoiceing');
Route::post('storedetinvoiceing',[FacturasController::class,'storedetinvoiceing'])->name('storedetinvoiceing');
Route::get('totalinvoice/{idfact}',[FacturasController::class,'totalinvoice'])->name('totalinvoice');
Route::get('deleteInvoice/{idfact}',[FacturasController::class,'deleteInvoice'])->name('deleteInvoice');
Route::get('deletefact/{idfact}/{idcfact}',[FacturasController::class,'deletefact'])->name('deletefact');




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
Route::post('verifyaccount', 'IncomeController@verifyaccount')->name('verifyaccount');
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

//Orden de compra
Route::get('reportorder',[PurchaseOrderController::class,'reportorder'])->name('reportorder');
Route::get('findsupplier',[PurchaseOrderController::class,'findsupplier'])->name('findsupplier');
Route::post('create',[PurchaseOrderController::class,'create'])->name('create');
Route::post('storeorder',[PurchaseOrderController::class,'storeorder'])->name('storeorder');
Route::get('createdetorder/{numConcept}',[PurchaseOrderController::class,'createdetorder'])->name('createdetorder');
Route::post('storedetpurchase',[PurchaseOrderController::class,'storedetpurchase'])->name('storedetpurchase');
Route::get('totalorder/{idorco}',[PurchaseOrderController::class,'totalorder'])->name('totalorder');
Route::get('deleteorderco/{idorco}',[PurchaseOrderController::class,'deleteorderco'])->name('deleteorderco');
Route::get('deleteordercom/{idorco}',[PurchaseOrderController::class,'deleteordercom'])->name('deleteordercom');
Route::get('/autorizar/{idorco}',[PurchaseOrderController::class,'autorizar'])->name('autorizar');

//Orden de Pago 
Route::get('registerorder',[PayOrderController::class,'index'])->name('registerorder');
Route::get('createpayorder/{idprov}/{idorco}',[PayOrderController::class,'createpayorder'])->name('createpayorder');
Route::post('storeord',[PayOrderController::class,'store'])->name('storeord');
Route::get('detorder/{numConcept}/{tasa}',[PayOrderController::class,'detorder'])->name('detorder');
Route::post('storedet',[PayOrderController::class,'storedetorder'])->name('storedetorder');
Route::get('totalorderpa/{idorpa}',[PayOrderController::class,'totalorder'])->name('totalorderpa');
Route::get('deleteorderpa/{idprov}/{idorco}',[PayOrderController::class,'deleteorderpa'])->name('deleteorderpa');
Route::get('deletedetorderpa/{idorpa}',[PayOrderController::class,'deletedetorderpa'])->name('deletedetorderpa');

//Registro de pago
Route::get('registerpay',[PayController::class,'index'])->name('registerpay');
Route::get('createpay/{idprov}/{idorpa}',[PayController::class,'create'])->name('createpay');
Route::post('storepay',[PayController::class,'store'])->name('storepay');
Route::get('deletepay/{idorpa}',[PayController::class,'destroy'])->name('deletepay');
Route::get('groupaccount1', [PayController::class, 'groupaccount1']);
Route::post('subgroupaccount1/{idgru}', [PayController::class, 'subgroupaccount1']);
Route::post('accountname1/{idsgr}', [PayController::class, 'accountname1']);
Route::post('subaccountname1/{idgcu}', [PayController::class, 'subaccountname1']);
Route::get('groupaccount2', [PayController::class, 'groupaccount2']);
Route::post('subgroupaccount2/{idgru}', [PayController::class, 'subgroupaccount2']);
Route::post('accountname2/{idsgr}', [PayController::class, 'accountname2']);
Route::post('subaccountname2/{idgcu}', [PayController::class, 'subaccountname2']);


Route::get('/excel/importar', [Importexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importexcel::class, 'importarexcel'])->name('/excel/importarexcel');

