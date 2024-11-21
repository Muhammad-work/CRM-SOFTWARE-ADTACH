<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HelpController;
use App\Http\Middleware\validUser;
use App\Http\Middleware\validRole;

// Dashboard Routes
Route::controller(dashboardController::class)->group(function () {
    Route::get('/dashboard', 'viewDashboard')->name('dashboard')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/viewAgentSaleTable', 'viewAgentSaleTable')->name('viewAgentSaleTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/viewAgentLeadlTable', 'viewAgentLeadlTable')->name('viewAgentLeadlTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/viewAgentTrialTable', 'viewAgentTrialTable')->name('viewAgentTrialTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/update_customer', 'cutomerUPdateDetailFormVIew')->name('cutomerUPdateDetailFormVIew')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/cutomerUPdateDetailStore', 'cutomerUPdateDetailStore')->name('cutomerUPdateDetailStore')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/cutomerUPdateDetailSaleStore', 'cutomerUPdateDetailSaleStore')->name('cutomerUPdateDetailSaleStore')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/cutomerUPdateDetailTrialStore', 'cutomerUPdateDetailTrialStore')->name('cutomerUPdateDetailTrialStore')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/cutomerUPdateSaleDetailFormVIew', 'cutomerUPdateSaleDetailFormVIew')->name('cutomerUPdateSaleDetailFormVIew')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/cutomerUPdateTrialDetailFormVIew', 'cutomerUPdateTrialDetailFormVIew')->name('cutomerUPdateTrialDetailFormVIew')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/deleteLeadCustomerDetails', 'deleteLeadCustomerDetails')->name('deleteLeadCustomerDetails')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/deleteSaleCustomerDetails', 'deleteSaleCustomerDetails')->name('deleteSaleCustomerDetails')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/deleteTrialCustomerDetails', 'deleteTrialCustomerDetails')->name('deleteTrialCustomerDetails')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/updateCustomerStatus', 'updateCustomerStatus')->name('updateCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/deleteCustomerDetails', 'deleteCustomerDetails')->name('deleteCustomerDetails')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/Help-Request', 'viewHelpRequestTableDashboard')->name('viewHelpRequestTableDashboard')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/downHelpRequestStatus', 'downHelpRequestStatus')->name('downHelpRequestStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/cancelHelpRequestStatus', 'cancelHelpRequestStatus')->name('cancelHelpRequestStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/viewTrialDaysForm', 'viewTrialDaysForm')->name('viewTrialDaysForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/storeTrialDays', 'storeTrialDays')->name('storeTrialDays')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/update-customer-status', 'updateStatusCustomerTrial')->name('updateStatusCustomerTrial')->middleware(validUser::class);
    Route::get('/dashboard/{id}/view-update-customer-status', 'viewupdateSaleCustomerStatus')->name('viewupdateSaleCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/update-customer-sale-status', 'updateSaleCustomerStatus')->name('updateSaleCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/add-customer-sale-day', 'viewSaleDaysForm')->name('viewSaleDaysForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/addSaleCustomerStatus', 'addSaleCustomerStatus')->name('addSaleCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
});

// User Routes
Route::controller(userController::class)->middleware(validUser::class)->middleware(validRole::class)->group(function () {
    Route::get('/dashboard/all-user', 'viewUserTable')->name('viewUserTable');
    Route::get('/dashboard/add-user', 'addUser')->name('addUser');
    Route::get('/dashboard/{id}/update-user', 'viewEditForm')->name('viewEditFormUser');
    Route::post('/dashboard/storeUserdetail', 'storeUserdetail')->name('storeUserdetail');
    Route::post('/dashboard/{id}/storeUpdateUser', 'storeUpdateUser')->name('storeUpdateUser');
    Route::get('/dashboard/{id}/deleteUser', 'deleteUser')->name('deleteUser');
   
});

// Admin Routes
Route::controller(adminController::class)->middleware(validUser::class)->middleware(validRole::class)->group(function () {
    Route::get('/dashboard/all-admin', 'viewAdminTable')->name('viewAdminTable');
    Route::get('/dashboard/add-admin', 'viewAddForm')->name('viewAddForm');
    Route::get('/dashboard/{id}/edit-admin', 'viewEditForm')->name('viewEditFormAdmin');
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

Route::controller(HelpController::class)->group(function () {
    Route::get('/help-Request', 'viewHelpForm')->name('help')->middleware(validUser::class); 
    Route::get('/help-Detail', 'viewHelpTable')->name('viewHelpTable')->middleware(validUser::class); 
    Route::post('/storeHelpRequest', 'storeHelpRequest')->name('storeHelpRequest')->middleware(validUser::class); 
});



// Route::get('/help',function(){
//   return view('front.help');
// })->name('help');

