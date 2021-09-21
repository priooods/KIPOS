<?php

use Illuminate\Support\Facades\Session;
Route::get('/', 'Dashboard@index')->name('halaman.home');
Route::get('/user/login', 'Login@index')->name('login');
Route::post('call_login', 'Login@method_login');


// EMKL Routes Setup

Route::post('new_emkls', 'TruckAllocation@save_emkls');
Route::get('details_emkls', 'TruckAllocation@get_detail');
Route::post('delete_emkls', 'TruckAllocation@delete_emkls');
Route::get('send_request', 'TruckAllocation@send_request');
Route::post('sendemail', 'TruckAllocation@sendEmails');

Route::get('details_gto', 'ApprovalGto@get_detail');
Route::post('approve_gto', 'ApprovalGto@Approved');
Route::post('rejected_gto', 'ApprovalGto@Rejected');
Route::post('cari_gto', 'ApprovalGto@searching');

Route::prefix('allocation')->group(function () {
    Route::get('/', 'TruckAllocation@index')->name('halaman.truckallocation.index');
    Route::get('/{id}', 'TruckAllocation@index_details')->name('halaman.truckallocation.detail');
});

Route::prefix('approval')->group(function () {
    Route::get('/gto/{token}', 'ApprovalGto@index')->name('halaman.approval_gto.index');
    Route::get('/gto/{token}/{id}', 'ApprovalGto@index_details')->name('halaman.approval_gto.detail_gto');
});

Route::prefix('emkls')->group(function () {
    Route::get('/{token}/{id}/{emkl}', 'ApprovalEmkls@index')->name('halaman.approval_emkl.index');
});
Route::post('emkls_verif', 'ApprovalEmkls@verifyed');
Route::post('emkls_reject', 'ApprovalEmkls@rejectEmails');

Route::prefix('index')->group(function () {
    Route::get('call_truck', 'TruckAllocation@method_truck');
    Route::get('call_consigne', 'TruckAllocation@method_consignee');
    Route::get('call_driver', 'TruckAllocation@method_driver');
    Route::get('call_routes', 'TruckAllocation@method_routes');
    Route::get('call_logout', 'Dashboard@method_logout');
});
//End Region


// Survey Routes Setup