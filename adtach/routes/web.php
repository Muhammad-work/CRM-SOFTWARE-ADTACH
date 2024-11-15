<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\CustomerController;
use App\Http\Middleware\validUser;
use App\Http\Middleware\validRole;

// Dashboard Routes
Route::controller(dashboardController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard')->name('dashboard')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/viewAgentSaleTable', 'viewAgentSaleTable')->name('viewAgentSaleTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/viewAgentLeadlTable', 'viewAgentLeadlTable')->name('viewAgentLeadlTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/viewAgentTrialTable', 'viewAgentTrialTable')->name('viewAgentTrialTable')->middleware(validUser::class)->middleware(validRole::class);
});

// User Routes
Route::controller(userController::class)->middleware(validUser::class)->middleware(validRole::class)->group(function () {
    Route::get('/dashboard/all-user', 'viewUserTable')->name('viewUserTable');
    Route::get('/dashboard/add-user', 'addUser')->name('addUser');
    Route::get('/dashboard/{id}/update-user', 'viewEditForm')->name('viewEditForm');
    Route::post('/dashboard/storeUserdetail', 'storeUserdetail')->name('storeUserdetail');
    Route::post('/dashboard/{id}/storeUpdateUser', 'storeUpdateUser')->name('storeUpdateUser');
    Route::get('/dashboard/{id}/deleteUser', 'deleteUser')->name('deleteUser');
   
});

// Admin Routes
Route::controller(adminController::class)->middleware(validUser::class)->middleware(validRole::class)->group(function () {
    Route::get('/dashboard/all-admin', 'viewAdminTable')->name('viewAdminTable');
    Route::get('/dashboard/add-admin', 'viewAddForm')->name('viewAddForm');
    Route::get('/dashboard/{id}/edit-admin', 'viewEditForm')->name('viewEditForm');
    Route::post('/dashboard/storeAdminDetail', 'storeAdminDetail')->name('storeAdminDetail');
    Route::post('/dashboard/{id}/storeUpdateAdmin', 'storeUpdateAdmin')->name('storeUpdateAdmin');
    Route::get('/dashboard/{id}/deleteAdmin', 'deleteAdmin')->name('deleteAdmin');
});

// Login Routes (No middleware needed for login routes)
Route::controller(userController::class)->group(function () {
    Route::get('/login', 'login')->name('login');
    Route::post('/storeLogin', 'loginstore')->name('loginstore');
    Route::get('/logout', 'logout')->name('logout');
});


Route::controller(homeController::class)->group(function () {
    Route::get('/', 'viewHome')->name('viewHome')->middleware(validUser::class); 
});
Route::controller(CustomerController::class)->group(function () {
    Route::post('/storeCustomerDetail', 'storeCustomerDetail')->name('storeCustomerDetail'); 
    Route::post('/customerStatus/{id}', 'customerStatus')->name('customerStatus'); 
    Route::get('/customerSalesTable', 'customerSalesTable')->name('customerSalesTable')->middleware(validUser::class); 
    Route::get('/customerLeadTable', 'customerLeadTable')->name('customerLeadTable')->middleware(validUser::class); 
    Route::get('/customerTrialTable', 'customerTrialTable')->name('customerTrialTable')->middleware(validUser::class); 
});


