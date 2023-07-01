<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use Spatie\Permission\Traits\HasPermissions;
use App\Http\Controllers\AsientoController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\Importexcel;
use App\Http\Controllers\FacturasController;
use App\Http\Controllers\ComprIngController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\PayOrderController;
use App\Http\Controllers\PayController;
use App\Http\Controllers\RetentionController;
use App\Http\Controllers\RetentionIslrController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\ConfigPayrollController;
use App\Http\Controllers\OutSeatController;
use App\Http\Controllers\ProyectGastController;
use App\Http\Controllers\diaryBookController;
use App\Http\Controllers\ReportIngGastController;
use Illuminate\Support\Facades\Auth;
//use App\Http\Controllers\ClientesController;


Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('admin/users/index', [UserController::class, 'index'])->name('users.index');
/* Route::get('admin/users/index', [UserController::class, 'index'])->middleware('can:')->name('users.index');
 */

Route::resource('users', UserController::class)->only(['index','edit','update'])->names('users');
Route::resource('roles', RoleController::class)->names('roles');

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
Route::get('invoicepdf/{idfact}/{idcli}',[FacturasController::class,'convertToPdf'])->name('invoicepdf');
Route::get('deleteInvoice/{idfact}',[FacturasController::class,'deleteInvoice'])->name('deleteInvoice');
Route::get('deletefact/{idfact}/{idcfact}',[FacturasController::class,'deletefact'])->name('deletefact');




//Comprobante de ingreso
Route::get('searchInvoice',[ComprIngController::class,'searchInvoice'])->name('searchInvoice');
Route::post('findInvoice',[ComprIngController::class,'findInvoice'])->name('findInvoice');
Route::get('createIncome/{idfact}/{idcli}',[ComprIngController::class,'createIncome'])->name('createIncome');
Route::post('storeproof',[ComprIngController::class,'storeproof'])->name('storeproof');
Route::get('totalproof/{idcom}',[ComprIngController::class,'totalproof'])->name('totalproof');
Route::get('proofinvoicepdf/{idcom}/{idcli}',[ComprIngController::class,'convertToPdf'])->name('proofinvoicepdf');
Route::get('deleteproof/{idcom}',[ComprIngController::class,'deleteproof'])->name('deleteproof');

//Ingreso
Route::get('searchIncome',[IncomeController::class,'searchIncome'])->name('searchIncome');
Route::post('findIncome',[IncomeController::class,'findIncome'])->name('findIncome');
Route::get('createIng/{idfact}/{idcli}',[IncomeController::class,'createIng'])->name('createIng');
Route::post('storeIncome',[IncomeController::class,'storeIncome'])->name('storeIncome');
Route::get('imprIncome/{idfact}/{idcli}/{idcom}',[IncomeController::class,'imprIncome'])->name('imprIncome');
Route::get('imprfactlegal/{idfact}/{idcli}/{idcom}',[IncomeController::class,'imprfactlegal'])->name('imprfactlegal');
Route::get('imprreportingr/{idfact}/{idcli}/{idcom}',[IncomeController::class,'imprreportingr'])->name('imprreportingr');

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
Route::resource('catsupplier','App\Http\Controllers\CatSupplierController')->only('index','create','store','edit','update');

//Orden de compra
Route::get('reportorder',[PurchaseOrderController::class,'reportorder'])->name('reportorder');
Route::get('findsupplier',[PurchaseOrderController::class,'findsupplier'])->name('findsupplier');
Route::post('create',[PurchaseOrderController::class,'create'])->name('create');
Route::post('storeorder',[PurchaseOrderController::class,'storeorder'])->name('storeorder');
Route::get('createdetorder/{numConcept}/{tasa_cambio}',[PurchaseOrderController::class,'createdetorder'])->name('createdetorder');
Route::post('storedetpurchase',[PurchaseOrderController::class,'storedetpurchase'])->name('storedetpurchase');
Route::get('totalorder/{idorco}',[PurchaseOrderController::class,'totalorder'])->name('totalorder');
Route::get('deleteorderco/{idorco}', [PurchaseOrderController::class, 'deleteorderco'])->name('deleteorderco');
Route::get('deleteordercom/{idorco}',[PurchaseOrderController::class,'deleteordercom'])->name('deleteordercom');
Route::get('autorizar/{idorco}',[PurchaseOrderController::class,'autorizar'])->name('autorizar');

//Orden de Pago 
Route::get('registerorder',[PayOrderController::class,'index'])->name('registerorder');
Route::get('createpayorder/{idprov}/{idorco}',[PayOrderController::class,'createpayorder'])->name('createpayorder');
Route::post('storeord',[PayOrderController::class,'store'])->name('storeord');
Route::get('detorder/{numConcept}/{tasa}',[PayOrderController::class,'detorder'])->name('detorder');
Route::post('storedet',[PayOrderController::class,'storedetorder'])->name('storedetorder');
Route::get('totalorderpa/{idorpa}',[PayOrderController::class,'totalorder'])->name('totalorderpa');
Route::get('payorderpdf/{idorpa}/{idprov}',[PayOrderController::class,'payorderpdf'])->name('payorderpdf');
Route::get('deleteorderpa/{idprov}/{idorco}',[PayOrderController::class,'deleteorderpa'])->name('deleteorderpa');
Route::get('deletedetorderpa/{idorpa}',[PayOrderController::class,'deletedetorderpa'])->name('deletedetorderpa');

//Registro de pago
Route::get('registerpay',[PayController::class,'index'])->name('registerpay');
Route::get('createpay/{idprov}/{idorpa}',[PayController::class,'create'])->name('createpay');
Route::post('storepay',[PayController::class,'store'])->name('storepay');
Route::get('totalpay/{idorpa}{idprov}',[PayController::class,'totalpay'])->name('totalpay');
Route::get('relegrepdf/{idorpa}/{idprov}',[PayController::class,'relegrepdf'])->name('relegrepdf');
Route::get('deletepay/{idorpa}',[PayController::class,'destroy'])->name('deletepay');
Route::get('groupaccount1', [PayController::class, 'groupaccount1']);
Route::post('subgroupaccount1/{idgru}', [PayController::class, 'subgroupaccount1']);
Route::post('accountname1/{idsgr}', [PayController::class, 'accountname1']);
Route::post('subaccountname1/{idgcu}', [PayController::class, 'subaccountname1']);
Route::get('groupaccount2', [PayController::class, 'groupaccount2']);
Route::post('subgroupaccount2/{idgru}', [PayController::class, 'subgroupaccount2']);
Route::post('accountname2/{idsgr}', [PayController::class, 'accountname2']);
Route::post('subaccountname2/{idgcu}', [PayController::class, 'subaccountname2']);

//retenciones iva
Route::get('listpay',[RetentionController::class,'index'])->name('listpay');
Route::get('createretention/{idorpa}/{idprov}',[RetentionController::class,'create'])->name('createretention');
Route::get('createretening/{idfact}/{idcli}',[RetentionController::class,'createretening'])->name('createretening');
Route::post('storeretening',[RetentionController::class,'storeretening'])->name('storeretening');
Route::post('storeretention',[RetentionController::class,'store'])->name('storeretention');
Route::get('totalretentioniva/{idret}/{inding}',[RetentionController::class,'totalretentioniva'])->name('totalretentioniva');
Route::get('retentionpdf/{idret}/{inding}',[RetentionController::class,'pdf'])->name('retentionpdf');

//ISLR
Route::get('findagent',[RetentionIslrController::class,'index'])->name('findagent');
Route::post('listreten',[RetentionIslrController::class,'listreten'])->name('listreten');
Route::get('createislr/{idorpa}/{idprov}/{idage}', [RetentionIslrController::class, 'create'])->name('createislr');
Route::post('storeislr',[RetentionIslrController::class,'store'])->name('storeislr');
Route::get('totalislr/{idreti}/{idprov}',[RetentionIslrController::class,'totalislr'])->name('totalislr');
Route::get('islrpdf/{idreti}/{idprov}',[RetentionIslrController::class,'islrpdf'])->name('islrpdf');

Route::get('tipcontribuyente', [RetentionIslrController::class, 'tipcontribuyente']);
Route::post('tipagente/{tippersona}', [RetentionIslrController::class, 'tipagente']);

//NOMINA
Route::resource('payroll', 'App\Http\Controllers\PayrollController');
Route::get('payemployee/{idnom}', [PayrollController::class,'payemployee'])->name('payemployee');
Route::post('storepayemployee', [PayrollController::class,'storepayemployee'])->name('storepayemployee');
Route::get('totalpayemployee/{idnom}/{idtnom}/{fecpag}/{dayst}',[PayrollController::class,'totalpayemployee'])->name('totalpayemployee');
Route::get('proofemployee/{idnom}/{idtnom}/{fecpag}/{dayst}',[PayrollController::class,'proofemployee'])->name('proofemployee');
//cargos del empleado
Route::get('chargescreate', [ConfigPayrollController::class,'chargescreate'])->name('chargescreate');
Route::post('chargesStore', [ConfigPayrollController::class,'chargesStore'])->name('chargesStore');
Route::get('chargeedit/{idcarg}', [ConfigPayrollController::class,'chargeedit'])->name('chargeedit');
Route::post('chargesupdate/{idcarg}', [ConfigPayrollController::class,'chargesupdate'])->name('chargesupdate');
Route::get('chargesdelete/{idcarg}', [ConfigPayrollController::class,'chargesdelete'])->name('chargesdelete');

//valores de pago
Route::get('createvalue',[ConfigPayrollController::class,'createvalue'])->name('createvalue');
Route::post('storevalue',[ConfigPayrollController::class,'storevalue'])->name('storevalue');
Route::get('valueedit/{idval}', [ConfigPayrollController::class,'valueedit'])->name('valueedit');
Route::post('valueupdate/{idval}',[ConfigPayrollController::class,'valueupdate'])->name('valueupdate');
Route::get('valuedelete/{idval}', [ConfigPayrollController::class,'valuedelete'])->name('valuedelete');

//PROYECCION DE GASTOS
Route::get('proyectgast',[ProyectGastController::class,'index'])->name('proyectgast');
Route::get('createproyectgast',[ProyectGastController::class,'createproyectgast'])->name('createproyectgast');
Route::post('storeproyectgast',[ProyectGastController::class,'storeproyectgast'])->name('storeproyectgast');


//libro diario
Route::get('diarybook',[diaryBookController::class,'index'])->name('diarybook');
Route::post('storebook',[diaryBookController::class,'storebook'])->name('storebook');

//Reporte de ingresos y egresos
Route::get('reporting',[ReportIngGastController::class,'reporting'])->name('reporting');
Route::post('storereporting',[ReportIngGastController::class,'storeing'])->name('storereporting');
Route::get('reportgast',[ReportIngGastController::class,'reportgast'])->name('reportgast');
Route::post('storereportgast',[ReportIngGastController::class,'storegast'])->name('storereportgast');


Route::get('/excel/importar', [Importexcel::class, 'impportar'])->name('/excel/importar');
Route::post('/excel/importarexcel', [Importexcel::class, 'importarexcel'])->name('/excel/importarexcel');

