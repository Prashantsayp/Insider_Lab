<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::post('login', 'UserAPIController@authenticate');
Route::post('register/{id}', 'UserAPIController@register');
Route::post('send-otp', 'UserAPIController@sendOTP');
Route::post('verify-otp', 'UserAPIController@verifyOTP');
Route::get('get-questions', 'UserAPIController@questionsList');
Route::post('save-questions', 'UserAPIController@saveQuestions');
Route::post('assets', 'FileHandlerController@uploadFileNew');
Route::get('get_agent_name', 'homeAPIController@get_agent_name');
Route::get('get_all_products', 'homeAPIController@get_all_products');
Route::get('product_details/{id}', 'homeAPIController@product_details');


Route::post('forget-password-send-otp', 'UserAPIController@forgetPasswordSendOTP');
Route::post('verify-otp-reset-password', 'UserAPIController@verifyOTPResetPassword');
Route::get('clear', function() {
    \Illuminate\Support\Facades\Artisan::call('cache:clear');
    \Illuminate\Support\Facades\Artisan::call('config:clear');
    \Illuminate\Support\Facades\Artisan::call('config:cache');
    \Illuminate\Support\Facades\Artisan::call('view:clear');
    return "Cleared!";
});
Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('home', 'homeAPIController@index');
    Route::get('user', 'UserAPIController@getAuthenticatedUser');
    Route::resource('cases', 'CasesAPIController');
    Route::put('cases/submit/{id}', 'CasesAPIController@submit');
    Route::resource('pin_codes', 'PinCodesAPIController');
    Route::resource('products', 'ProductsAPIController');
    Route::get("professional_analytics", "ProfessionalPolicyDetailsAPIController@getAnalytics");
    Route::post('documents', 'FileHandlerController@uploadDocumentsNew');
    Route::delete('documents/{id}', 'FileHandlerController@deleteDocument');
    Route::resource('agents', 'AgentsAPIController');
    Route::post('change-password', 'UserAPIController@changePassword');
    Route::get('agent-details', 'UserAPIController@agentDetails');
    Route::post('agent-update', 'UserAPIController@agentUpdate');
	
	
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::post('Create-Cases', 'CasesAPIController@caseCreate');
    Route::post('Product-Select-Loan', 'CasesAPIController@updateLoanProduct');
    Route::post('Update-Agent', 'UserAPIController@updateAgent');
    Route::post('Update-Cases', 'CasesAPIController@updateCases');
    Route::get('Get-Case-Status', 'CasesAPIController@getCaseStatus');
    
    Route::get('Eligibility-Status', 'CasesAPIController@eligibilityStatus');
    Route::get('Final-Loan-Approval-Case', 'CasesAPIController@finalLoanApprovalCase');
    Route::get('Comments-Case-list', 'CasesAPIController@commentCaseList');
    Route::get('Document-Type-Case-List', 'CasesAPIController@documentCaseList');
    Route::post('Comments-Sent', 'CasesAPIController@commentsSent');
    Route::post('Final-Case-List', 'CasesAPIController@finalCaseList');
    Route::get('Get-All-Status', 'CasesAPIController@getAllStatus');
    Route::get('Get-All-Actions', 'CasesAPIController@getAllActions');
});

Route::group(['middleware' => ['jwt.verify']], function () {
    Route::get('Media-Page-Notification', 'CasesAPIController@mediaPageNotification');    
});

Route::get('agent-details-new', 'UserAPIController@getDetailsNew');


Route::fallback(function () {
    return response()->json([
        "error" => 1,
        'message' => 'Request url not found on this server',
        "show_message" => true
    ], 404);
});







