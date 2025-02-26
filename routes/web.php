<?php

use PharIo\Manifest\AuthorElement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Panel\DoctorController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\DoctorRoleController;
use App\Http\Controllers\Panel\InsurancesController;
use App\Http\Controllers\Panel\OperationController;
use App\Http\Controllers\Panel\SpecialityController;
use App\Http\Controllers\Panel\SurgeryController;

Route::get('/login', [AuthController::class, 'FormLogin'])->name('FormLogin');
Route::post('/login', [AuthController::class, 'Login'])->name('Login');
Route::prefix('panel')->middleware('auth')->group(function () {
    Route::get('/Panel', [PanelController::class, 'Panel'])->name('Panel');

     Route::prefix("users")->group(function () {

        Route::get('/Panel/StoreUser', [UserController::class, 'Store'])->name('Panel.CreateUser');
        Route::post('/Panel/StoreUser', [UserController::class, 'Save'])->name('Panel.SaveUser');
        Route::get('/Panel/UserList', [UserController::class, 'UserList'])->name('Panel.UserList');
        Route::get('/Panel/edit/{id}', [UserController::class, 'Edit'])->name('Panel.Edit');
        Route::post('/Panel/UpdateUser/{id}', [UserController::class, 'Update'])->name('Panel.UpdateUser');
        Route::get('/Panel/Delete/{id}', [UserController::class, 'Delete'])->name('Panel.DeleteUser');
        });
    Route::prefix('specialities')->group(function () {
            Route::get('/index', [SpecialityController::class, 'index'])->name('Panel.SpecialitiesList');
            Route::get('/create', [SpecialityController::class, 'create'])->name('Panel.CreateSpeciality');
            Route::post('/store', [SpecialityController::class, 'store'])->name('Panel.StoreSpeciality');
            Route::get('/edit/{id}', [SpecialityController::class, 'edit'])->name('Panel.EditSpeciality');
            Route::post('/update/{id}', [SpecialityController::class, 'update'])->name('Panel.UpdateSpeciality');
            Route::get('/delete/{id}', [SpecialityController::class, 'destroy'])->name('Panel.DeleteSpeciality');
            Route::get('/search', [SpecialityController::class, 'filters'])->name('Panel.SearchSpeciality');
        });

    Route::prefix('rolesDoctor')->group(function () {
        Route::get('/roles-doctor', [DoctorRoleController::class, 'index'])->name('Panel.RolesDoctorList');
        Route::get('/roles-doctor/create', [DoctorRoleController::class, 'create'])->name('Panel.CreateRolesDoctor');
        Route::post('/roles-doctor', [DoctorRoleController::class, 'store'])->name('Panel.StoreRolesDoctor');
        Route::get('/roles-doctor/edit/{id}', [DoctorRoleController::class, 'edit'])->name('Panel.EditRolesDoctor');
        Route::post('/roles-doctor/update/{id}', [DoctorRoleController::class, 'update'])->name('Panel.UpdateRolesDoctor');
        Route::get('/roles-doctor/delete/{id}', [DoctorRoleController::class, 'destroy'])->name('Panel.DeleteRolesDoctor');
        Route::get('/roles-doctor/search', [DoctorRoleController::class, 'filters'])->name('Panel.SearchDoctorRole');
    });
    Route::prefix('Doctor')->group(function () {
        Route::get('/doctor', [DoctorController::class, 'index'])->name('Panel.DoctorList');
        Route::get('/doctor/create', [DoctorController::class, 'create'])->name('Panel.CreateDoctor');
        Route::post('/doctor', [DoctorController::class, 'store'])->name('Panel.StoreDoctor');
        Route::get('/doctor/edit/{id}', [DoctorController::class, 'edit'])->name('Panel.EditDoctor');
        Route::post('/doctor/update/{id}', [DoctorController::class, 'update'])->name('Panel.UpdateDoctor');
        Route::get('/doctor/delete/{id}', [DoctorController::class, 'destroy'])->name('Panel.DeleteDoctor');
        Route::get('/doctor/search', [DoctorController::class, 'filters'])->name('Panel.SearchDoctor');
    });
    Route::prefix('insurances')->group(function () {
        Route::get('/insurances', [InsurancesController::class, 'index'])->name('Panel.InsuranceList');
        Route::get('/insurances/create', [InsurancesController::class, 'create'])->name('Panel.CreateInsurance');
        Route::post('/insurances/store', [InsurancesController::class, 'store'])->name('Panel.StoreInsurance');
        Route::get('/insurances/edit/{id}', [InsurancesController::class, 'edit'])->name('Panel.EditInsurance');
         Route::post('/insurances/update/{id}', [InsurancesController::class, 'update'])->name('Panel.UpdateInsurance');
        Route::get('/insurances/delete/{id}', [InsurancesController::class, 'destroy'])->name('Panel.DeleteInsurance');
        Route::get('/insurances/filters', [InsurancesController::class, 'filters'])->name('Panel.Searchinsurances');
});
Route::prefix('Operation')->group(function () {
    Route::get('/Operation', [OperationController::class, 'index'])->name('Panel.OperationList');
    Route::get('/Operation/create', [OperationController::class, 'create'])->name('Panel.CreateOperation');
    Route::post('/Operation/store', [OperationController::class, 'store'])->name('Panel.StoreOperation');
    Route::get('/Operation/edit/{id}', [OperationController::class, 'edit'])->name('Panel.EditOperation');
     Route::post('/Operation/update/{id}', [OperationController::class, 'update'])->name('Panel.UpdateOperation');
    Route::get('/Operation/delete/{id}', [OperationController::class, 'destroy'])->name('Panel.DeleteOperation');
    Route::get('/Operation/filters', [OperationController::class, 'filters'])->name('Panel.SearchOperation');
});
Route::prefix('Surgery')->group(function () {
    Route::get('/Surgery', [SurgeryController::class, 'index'])->name('Panel.SurgeryList');
    Route::get('/Surgery/create', [SurgeryController::class, 'create'])->name('Panel.CreateSurgery');
    Route::post('/Surgery/store', [SurgeryController::class, 'store'])->name('Panel.StoreSurgery');
    Route::get('/Surgery/edit/{id}', [SurgeryController::class, 'edit'])->name('Panel.EditSurgery');
     Route::post('/Surgery/update/{id}', [SurgeryController::class, 'update'])->name('Panel.UpdateSurgery');
    Route::get('/Surgery/delete/{id}', [SurgeryController::class, 'destroy'])->name('Panel.DeleteSurgery');
    Route::get('/Surgery/filters', [SurgeryController::class, 'filters'])->name('Panel.SearchSurgery');
});
});

