<?php

use PharIo\Manifest\AuthorElement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\PanelController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SurgeryController;
use App\Http\Controllers\Admin\OperationController;
use App\Http\Controllers\Admin\DoctorRoleController;
use App\Http\Controllers\Admin\InsurancesController;
use App\Http\Controllers\Admin\SpecialityController;

Route::get('/login', [AuthController::class, 'FormLogin'])->name('FormLogin');
Route::post('/login', [AuthController::class, 'Login'])->name('Login');
Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/admin', [PanelController::class, 'Panel'])->name('Panel');

    Route::prefix("user")->group(function () {
        Route::get('/user-profile', [UserController::class, 'Profile'])->name('Profile');
        Route::get('/edit/{id}', [UserController::class, "Edit"])->name('editProfile');
        Route::post('/update/{id}', [UserController::class, "Update"])->name('updateProfile');
    });
    Route::prefix('specialities')->group(function () {
        Route::get('/index', [SpecialityController::class, 'index'])->name('Panel.SpecialitiesList');
        Route::get('/create', [SpecialityController::class, 'create'])->name('Panel.CreateSpeciality');
        Route::post('/store', [SpecialityController::class, 'store'])->name('Panel.StoreSpeciality');
        Route::get('/edit/{id}', [SpecialityController::class, 'edit'])->name('Panel.EditSpeciality');
        Route::post('/update/{id}', [SpecialityController::class, 'update'])->name('Panel.UpdateSpeciality');
        Route::delete('/delete/{id}', [SpecialityController::class, 'destroy'])->name('Panel.DeleteSpeciality');
        Route::get('/search', [SpecialityController::class, 'filters'])->name('Panel.SearchSpeciality');
    });

    Route::prefix('roles-doctor')->group(function () {
        Route::get('/roles-doctor', [DoctorRoleController::class, 'index'])->name('Panel.RolesDoctorList');
        Route::get('/roles-doctor/create', [DoctorRoleController::class, 'create'])->name('Panel.CreateRolesDoctor');
        Route::post('/roles-doctor', [DoctorRoleController::class, 'store'])->name('Panel.StoreRolesDoctor');
        Route::get('/roles-doctor/edit/{id}', [DoctorRoleController::class, 'edit'])->name('Panel.EditRolesDoctor');
        Route::post('/roles-doctor/update/{id}', [DoctorRoleController::class, 'update'])->name('Panel.UpdateRolesDoctor');
        Route::delete('/roles-doctor/delete/{id}', [DoctorRoleController::class, 'destroy'])->name('Panel.DeleteRolesDoctor');
        Route::get('/roles-doctor/search', [DoctorRoleController::class, 'filters'])->name('Panel.SearchDoctorRole');
    });
    Route::prefix('doctor')->group(function () {
        Route::get('/doctor', [DoctorController::class, 'index'])->name('Panel.DoctorList');
        Route::get('/doctor-create', [DoctorController::class, 'create'])->name('Panel.CreateDoctor');
        Route::post('/doctor', [DoctorController::class, 'store'])->name('Panel.StoreDoctor');
        Route::get('/doctor-edit/{id}', [DoctorController::class, 'edit'])->name('Panel.EditDoctor');
        Route::post('/doctor-update/{id}', [DoctorController::class, 'update'])->name('Panel.UpdateDoctor');
        Route::delete('/doctor-delete/{id}', [DoctorController::class, 'destroy'])->name('Panel.DeleteDoctor');
        Route::get('/doctor-search', [DoctorController::class, 'filters'])->name('Panel.SearchDoctor');
        Route::get('/doctor-details/{id}', [DoctorController::class, 'details'])->name('Panel.DetailsDoctor');
    });
    Route::prefix('insurances')->group(function () {
        Route::get('/insurances', [InsurancesController::class, 'index'])->name('Panel.InsuranceList');
        Route::get('/insurances-create', [InsurancesController::class, 'create'])->name('Panel.CreateInsurance');
        Route::post('/insurances-store', [InsurancesController::class, 'store'])->name('Panel.StoreInsurance');
        Route::get('/insurances-edit/{id}', [InsurancesController::class, 'edit'])->name('Panel.EditInsurance');
        Route::post('/insurances-update/{id}', [InsurancesController::class, 'update'])->name('Panel.UpdateInsurance');
        Route::delete('/insurances-delete/{id}', [InsurancesController::class, 'destroy'])->name('Panel.DeleteInsurance');
        Route::get('/insurances-filters', [InsurancesController::class, 'filters'])->name('Panel.Searchinsurances');
    });
    Route::prefix('Operation')->group(function () {
        Route::get('/Operation', [OperationController::class, 'index'])->name('Panel.OperationList');
        Route::get('/Operation-create', [OperationController::class, 'create'])->name('Panel.CreateOperation');
        Route::post('/Operation-store', [OperationController::class, 'store'])->name('Panel.StoreOperation');
        Route::get('/Operation-edit/{id}', [OperationController::class, 'edit'])->name('Panel.EditOperation');
        Route::post('/Operation-update/{id}', [OperationController::class, 'update'])->name('Panel.UpdateOperation');
        Route::delete('/Operation-delete/{id}', [OperationController::class, 'destroy'])->name('Panel.DeleteOperation');
        Route::get('/Operation-filters', [OperationController::class, 'filters'])->name('Panel.SearchOperation');
    });
    Route::prefix('Surgery')->group(function () {
        Route::get('/Surgery', [SurgeryController::class, 'index'])->name('Panel.SurgeryList');
        Route::get('/Surgery-create', [SurgeryController::class, 'create'])->name('Panel.CreateSurgery');
        Route::post('/Surgery-store', [SurgeryController::class, 'store'])->name('Panel.StoreSurgery');
        Route::get('/Surgery-edit/{id}', [SurgeryController::class, 'edit'])->name('Panel.EditSurgery');
        Route::post('/Surgery-update/{id}', [SurgeryController::class, 'update'])->name('Panel.UpdateSurgery');
        Route::delete('/Surgery-delete/{id}', [SurgeryController::class, 'destroy'])->name('Panel.DeleteSurgery');
        Route::get('/Surgery-filters', [SurgeryController::class, 'filters'])->name('Panel.SearchSurgery');
        Route::get('/Surgery-details/{id}', [SurgeryController::class, 'details'])->name('Panel.DetailsSurgery');
    });

    Route::prefix('Invoice')->group(function () {
        Route::get('/Invoice', [InvoiceController::class, 'index'])->name('Panel.InvoiceList');
        Route::get('/pay', [InvoiceController::class, 'pay'])->name('Panel.InvoicePay');
        Route::get('/search-pay', [InvoiceController::class, 'searchPay'])->name('Panel.SearchInvoicePay');
        Route::post('/store', [InvoiceController::class, 'store'])->name('Panel.StoreInvoice');
        Route::get('/invoice-list', [InvoiceController::class, 'invoiceList'])->name('Panel.InvoiceList');
        Route::get('/edit/{id}', [InvoiceController::class, 'edit'])->name('Panel.EditInvoice');
        Route::delete('/delete/{id}', [InvoiceController::class, 'destroy'])->name('Panel.DeleteInvoice');
        Route::get('/invoices-filters', [InvoiceController::class, 'filters'])->name('Panel.InvoiceFilters');
    });
    Route::prefix('Payment')->group(function () {
        Route::get('/Payment/{id}', [PaymentController::class, 'index'])->name('Panel.StorePayment');
        Route::post('/payment/cash', [PaymentController::class, 'storePayment'])->name('Panel.storePayment');
        Route::delete('/delete/{id}', [PaymentController::class, 'deleteInvoice'])->name('Panel.deleteInvoice');
        Route::get('/invoice-print/{id}', [InvoiceController::class, 'print'])->name('Panel.print');
        Route::get('/doctor/{doctor_id}/invoice/{invoice_id}/payment-report', [PaymentController::class, 'paymentReport'])->name('Panel.ReportPayments');
    });
});
