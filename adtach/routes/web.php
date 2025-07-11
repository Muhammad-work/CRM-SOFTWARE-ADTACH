<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\adminController;
use App\Http\Controllers\homeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\HelpController;
use App\Http\Controllers\saleContoller;
use App\Http\Middleware\validUser;
use App\Http\Middleware\validRole;

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
    Route::get('/dashboard/{id}/viewTrialDaysForm', 'viewTrialDaysForm')->name('viewTrialDaysForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/update-customer-status', 'updateStatusCustomerTrial')->name('updateStatusCustomerTrial')->middleware(validUser::class);
    Route::get('/dashboard/{id}/view-update-customer-status', 'viewupdateSaleCustomerStatus')->name('viewupdateSaleCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/update-customer-sale-status', 'updateSaleCustomerStatus')->name('updateSaleCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/add-customer-sale-day', 'viewSaleDaysForm')->name('viewSaleDaysForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/addSaleCustomerStatus', 'addSaleCustomerStatus')->name('addSaleCustomerStatus')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/customer-numbers', 'viewCustomerNumber')->name('viewCustomerNumber')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/add-customer-numbers', 'viewCustomerNumberForm')->name('viewCustomerNumberForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/storeCustomerNumbers', 'storeCustomerNumbers')->name('storeCustomerNumbers')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/all-numbers', 'viewNumbersTable')->name('viewNumbersTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/add-numbers', 'viewAddNumbersForm')->name('viewAddNumbersForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/storeNumbers', 'storeNumbers')->name('storeNumbers')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/customer-response', 'viewAgentDistributeNumbersDetail')->name('viewAgentDistributeNumbersDetail')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/all-agent-sale-reports/{id}/', 'viewSaleTable')->name('viewSaleTable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/all-agent-lead-reports/{id}/', 'viewleadtable')->name('viewleadtable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/distribute-lead/{id}/', 'distributeLeadsForm')->name('distributeLeadsForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/updateLeadAgent/{id}', 'updateLeadAgent')->name('updateLeadAgent')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/distribute-number', 'distributeNumberForm')->name('distributeNumberForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/distributeNumberToAgent', 'distributeNumberToAgent')->name('distributeNumberToAgent')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/distributesaleToAgent', 'viewAgentDistributeSale')->name('viewAgentDistributeSale')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/all-agent-trial-report', 'viewtrialtable')->name('viewtrialtable')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/distributeTrialsForm', 'distributeTrialsForm')->name('distributeTrialsForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/updateSaleAgent', 'updateSaleAgent')->name('updateSaleAgent')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/updateTrialAgent', 'updateTrialAgent')->name('updateTrialAgent')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/all-agent-sale', 'filterSaleByDate')->name('filterSaleByDate')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/all-peding-sale', 'viewPendingSale')->name('viewPendingSale')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/{id}/acceptPendingSale', 'acceptPendingSale')->name('acceptPendingSale')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/mac_expiry', 'viewMacExpiryData')->name('viewMacExpiryData')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/add_sale', 'viewAddNewAgentSaleForm')->name('viewAddNewAgentSaleForm')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/save_sale', 'saveNewAgentSale')->name('saveNewAgentSale')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/old_number', 'viewOldNumber')->name('viewOldNumber')->middleware(validUser::class)->middleware(validRole::class);
    Route::get('/dashboard/dis_old_number', 'disOldCustomerNumberToAgent')->name('disOldCustomerNumberToAgent')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/dis_old_number', 'storeOldCustomerNumber')->name('storeOldCustomerNumber')->middleware(validUser::class)->middleware(validRole::class);
    Route::post('/dashboard/{id}/updateHelpRequeststatus', 'updateHelpRequeststatus')->name('updateHelpRequeststatus')->middleware(validUser::class)->middleware(validRole::class);
});


Route::controller(userController::class)->middleware(validUser::class)->middleware(validRole::class)->group(function () {
    Route::get('/dashboard/all-user', 'viewUserTable')->name('viewUserTable');
    Route::get('/dashboard/add-user', 'addUser')->name('addUser');
    Route::get('/dashboard/{id}/update-user', 'viewEditForm')->name('viewEditFormUser');
    Route::post('/dashboard/storeUserdetail', 'storeUserdetail')->name('storeUserdetail');
    Route::post('/dashboard/{id}/storeUpdateUser', 'storeUpdateUser')->name('storeUpdateUser');
    Route::get('/dashboard/{id}/deleteUser', 'deleteUser')->name('deleteUser');
    Route::get('/dashboard/sendMail', 'sendMail')->name('sendMail');
    Route::get('/dashboard/{id}/viewUserChangePassword', 'viewUserChangePassword')->name('viewUserChangePassword');
    Route::post('/dashboard/{id}/changeAgentPasswordStore', 'changeAgentPasswordStore')->name('changeAgentPasswordStore');
});

Route::get('/user/{id}/activate', [UserController::class, 'activateUser'])->name('activateUser');
Route::get('/user/{id}/deactivateUser', [UserController::class, 'deactivateUser'])->name('deactivateUser');


Route::controller(adminController::class)->middleware(validUser::class)->middleware(validRole::class)->group(function () {
    Route::get('/dashboard/all-admin', 'viewAdminTable')->name('viewAdminTable');
    Route::get('/dashboard/add-admin', 'viewAddForm')->name('viewAddForm');
    Route::get('/dashboard/{id}/edit-admin', 'viewEditForm')->name('viewEditFormAdmin');
    Route::post('/dashboard/storeAdminDetail', 'storeAdminDetail')->name('storeAdminDetail');
    Route::post('/dashboard/{id}/storeUpdateAdmin', 'storeUpdateAdmin')->name('storeUpdateAdmin');
    Route::get('/dashboard/{id}/deleteAdmin', 'deleteAdmin')->name('deleteAdmin');
    Route::get('/dashboard/change-password', 'viewAdminUpdatePasswordForm')->name('viewAdminUpdatePasswordForm');
    Route::post('/dashboard/{id}/changePasswordStore', 'changePasswordStore')->name('changePasswordStore');
});


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
    Route::get('/customer-numbers', 'viewCunstomerNumberTable')->name('viewCunstomerNumberTable')->middleware(validUser::class);
    Route::post('/{id}/storeCustomerNumbersDetails', 'storeCustomerNumbersDetails')->name('storeCustomerNumbersDetails')->middleware(validUser::class);
    Route::get('/{id}/edit-customer-numbers', 'viewCustomerNumberEditForm')->name('viewCustomerNumberEditForm')->middleware(validUser::class);
    Route::get('/{id}/add-old-customer-data', 'viewOldCustomerNewPKG')->name('viewOldCustomerNewPKG')->middleware(validUser::class);
    Route::post('/{id}/storeOldCustomerNewPKGData', 'storeOldCustomerNewPKGData')->name('storeOldCustomerNewPKGData')->middleware(validUser::class);
    Route::post('/{id}/storeCustomerNumberEditDetails', 'storeCustomerNumberEditDetails')->name('storeCustomerNumberEditDetails')->middleware(validUser::class);
    Route::get('/{id}/edit-sale', 'viewEditCustomerSaleDetailForm')->name('viewEditCustomerSaleDetailForm')->middleware(validUser::class);
    Route::post('/{id}/storeEditCustomerSaleDetails', 'storeEditCustomerSaleDetails')->name('storeEditCustomerSaleDetails')->middleware(validUser::class);
    Route::get('/{id}/update-lead', 'viewleadEditForm')->name('viewleadEditForm')->middleware(validUser::class);
    Route::get('/{id}/update-trial', 'viewTrialEditForm')->name('viewTrialEditForm')->middleware(validUser::class);
    Route::get('/customerDeniedTable', 'customerDeniedTable')->name('customerDeniedTable')->middleware(validUser::class);
    Route::post('/{id}/storeUpdateLeadData', 'storeUpdateLeadData')->name('storeUpdateLeadData')->middleware(validUser::class);
    Route::post('/{id}/storeUpdateTrialData', 'storeUpdateTrialData')->name('storeUpdateTrialData')->middleware(validUser::class);
});

Route::controller(HelpController::class)->group(function () {
    Route::get('/help-Request', 'viewHelpForm')->name('help')->middleware(validUser::class);
    Route::get('/help-Detail', 'viewHelpTable')->name('viewHelpTable')->middleware(validUser::class);
    Route::get('/update/{id}/remarks', 'updateRemarksForm')->name('updateRemarksForm')->middleware(validUser::class);
    Route::post('/storeHelpRequest', 'storeHelpRequest')->name('storeHelpRequest')->middleware(validUser::class);
    Route::post('/agent/{id}/remarks-update', 'agentRemarksUpdate')->name('agentRemarksUpdate')->middleware(validUser::class);
});