<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\CasesController;
use App\Http\Controllers\NotificationsController;
use App\Http\Controllers\MediaNotificationsController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// Auth::routes();
Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::get('/home', 'homeController@index')->name('home');

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// Auth::routes(['verify' => true]);
// Route::get('/home', 'homeController@index')->middleware('verified');

Route::get('clear', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Cleared!";
});

Route::resource('agents', 'AgentsController');

Route::get('/downloadCasesZip/{id}', 'CasesController@downloadCasesZip');

Route::resource('bankDetails', 'BankDetailsController');

Route::resource('cases', 'CasesController');

 Route::resource('homes', 'homeController');
// Route::resource('user', 'UserController');

Route::resource('policyDetails', 'PolicyDetailsController');

Route::get("evaluate", "ProfessionalPolicyDetailsController@evaluate");
Route::post("evaluate", "ProfessionalPolicyDetailsController@getDetails")->name("policyDetails.getDetails");



Route::resource('users', 'UserController');


Route::resource('professionalPolicyDetails', 'ProfessionalPolicyDetailsController');


Route::resource('pinCodes', 'PinCodesController');

Route::resource('products', 'ProductsController');

Route::resource('documents', 'DocumentsController');

//------------New Routes-------------------------

// ====================Case Routes===================

Route::group(['middleware' => ['auth']],function(){

        Route::get('Agent-show',[AgentsController::class, 'list'])->name('Agent-show');
        Route::get('Agent-Details',[AgentsController::class, 'details'])->name('Agent-Details');
        Route::get('Agent-Cases',[AgentsController::class, 'cases_list'])->name('Agent-Cases');
        Route::get('Agent-Cases-Personal',[AgentsController::class, 'cases_list_personal'])->name('Agent-Cases-Personal');
        Route::get('Agent-Cases-Business',[AgentsController::class, 'cases_list_business'])->name('Agent-Cases-Business');
        Route::post('Summary-create',[AgentsController::class, 'summary_create'])->name('Summary-create');
        Route::post('Bank-Earnings-create',[AgentsController::class, 'bank_earning_create'])->name('Bank-Earnings-create');
        Route::post('Bank-Transaction-create',[AgentsController::class, 'bank_transaction_create'])->name('Bank-Transaction-create');
        Route::post('Document-Update',[AgentsController::class, 'documents_update'])->name('Document-Update');
        Route::get('Agent-Status',[AgentsController::class, 'agentStatus'])->name('Agent-Status');
});

// ====================Case Routes===================

Route::group(['middleware' => ['auth']],function(){

        Route::get('Proffesional-Cases',[CasesController::class, 'proffesional_cases'])->name('Proffesional-Cases');
        Route::get('Personal-Cases',[CasesController::class, 'personal_cases'])->name('Personal-Cases');
        Route::get('Bussiness-Cases',[CasesController::class, 'bussiness_cases'])->name('Bussiness-Cases');
        Route::get('Case-Details',[CasesController::class, 'case_details'])->name('Case-Details');
        Route::post('Case-Update',[CasesController::class, 'case_update_new'])->name('Case-Update');
        Route::post('Case-Update-Eligibility',[CasesController::class, 'case_update_eligibility'])->name('Case-Update-Eligibility');
        Route::post('Case-Final-Bank-Approval',[CasesController::class, 'Case_Final_Bank_Approval'])->name('Case-Final-Bank-Approval');
        Route::post('Case-Privacy-Policy',[CasesController::class, 'Case_Privacy_Policy'])->name('Case-Privacy-Policy');
        Route::post('Case-Document-type',[CasesController::class, 'Case_Document_type'])->name('Case-Document-type');
        Route::get('Case-Status-Document',[CasesController::class, 'caseStatusDocument'])->name('Case-Status-Document');
        Route::get('Case-Flag-Document',[CasesController::class, 'caseFlagDocument'])->name('Case-Flag-Document');
        Route::post('Case-Comments',[CasesController::class, 'case_comments'])->name('Case-Comments');
});

// ====================Notifications===================

//Route::resource('global', 'NotificationsController');

Route::group(['middleware' => ['auth']],function(){

        Route::get('Notifications',[NotificationsController::class, 'index'])->name('Notifications');
        Route::get('Notifications-list',[NotificationsController::class, 'list'])->name('Notifications-list'); 
        Route::post('Notification-Save',[NotificationsController::class, 'store'])->name('Notification-Save'); 
        Route::get('Notification-Send',[NotificationsController::class, 'sendNotification'])->name('Notification-Send');

        Route::get('Notifications-Media',[MediaNotificationsController::class, 'index'])->name('Notifications-Media');
        Route::get('Media-Notifications-list',[MediaNotificationsController::class, 'list'])->name('Media-Notifications-list'); 
        Route::post('Media-Notification-Save',[MediaNotificationsController::class, 'store'])->name('Media-Notification-Save');  
        Route::post('Media-Notification-Delete',[MediaNotificationsController::class, 'destroy'])->name('Media-Notification-Delete'); 
        Route::post('Media-Notification-Disabled',[MediaNotificationsController::class, 'disabled'])->name('Media-Notification-Disabled');       
});
