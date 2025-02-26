<?php

use PharIo\Manifest\AuthorElement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Panel\UserController;
use App\Http\Controllers\Panel\PanelController;
use App\Http\Controllers\Panel\DoctorRoleController;
use App\Http\Controllers\Panel\SpecialityController;

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
});

