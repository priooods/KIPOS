<?php

use App\Http\Controllers\ApprovalEmkls;
use App\Http\Controllers\ApprovalGto;
use App\Http\Controllers\Dashboard;
use App\Http\Controllers\Login;
use App\Http\Controllers\TruckAllocation;


Route::get('/', [Dashboard::class,'index']);
Route::group(['middleware' => 'web'], function () {
    Route::get('user/login', [Login::class,'index'])->name('login');
    Route::post('user/login', [Login::class,'method_login']);

    Route::get('allocation', [TruckAllocation::class,'index'])->middleware('auth');
    Route::get('allocation/{id}', [TruckAllocation::class,'index_details'])->middleware('auth');

    Route::post('new_emkls', [TruckAllocation::class,'save_emkls']);
    Route::get('details_emkls', [TruckAllocation::class,'get_detail']);
    Route::post('delete_emkls', [TruckAllocation::class,'delete_emkls']);
    Route::get('send_request', [TruckAllocation::class,'send_request']);
    Route::post('sendemail', [TruckAllocation::class,'sendEmails']);

    Route::get('details_gto', [ApprovalGto::class, 'get_detail']);
    Route::post('approve_gto', [ApprovalGto::class,'Approved']);
    Route::post('rejected_gto', [ApprovalGto::class,'Rejected']);
    Route::post('cari_gto', [ApprovalGto::class,'searching']);

    Route::get('gto/{token}', [ApprovalGto::class,'index'])->middleware('auth');
    Route::get('gto/detail/{token}/{header_id}/', [ApprovalGto::class,'index_details']);

    Route::get('mkl/{token}/{user_id}/', [ApprovalEmkls::class,'index'])->middleware('auth');
    Route::get('mkl/detail/{token}/{header_id}', [ApprovalEmkls::class,'index_approved']);
    Route::post('cari_mkl', [ApprovalEmkls::class,'searching']);

    Route::get('details_mkl', [ApprovalEmkls::class, 'get_detail']);
    Route::post('emkls_verif', [ApprovalEmkls::class,'verifyed']);
    Route::post('emkls_reject', [ApprovalEmkls::class,'rejectEmails']);
});

Route::prefix('index')->group(function () {
    Route::get('call_truck', 'TruckAllocation@method_truck');
    Route::get('call_consigne', 'TruckAllocation@method_consignee');
    Route::get('call_driver', 'TruckAllocation@method_driver');
    Route::get('call_routes', 'TruckAllocation@method_routes');
    Route::get('call_logout', 'Dashboard@method_logout');
});
//End Region


// Survey Routes Setup
// Route::get('survey', 'surveycontroller@index')->name('survey');
Route::get('/survey/{token}', 'SurveyController@index')->name('halaman.survey.survey_index');
Route::post('/update-rating/{id}', 'SurveyController@update')->name('Update.rating');