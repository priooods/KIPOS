<?php

Route::get('/user/login', 'Login@index')->name('login');
Route::post('call_login', 'Login@method_login');

Route::post('new_emkls', 'TruckAllocation@save_emkls');
Route::get('delete_emkls/{id}', 'TruckAllocation@delete_emkls')->name('delete_emkl');
Route::post('send_request', 'TruckAllocation@send_request')->name('send_request_emkls');


Route::get('/', 'Dashboard@index')->name('halaman.home');

Route::prefix('allocation')->group(function () {
    Route::get('/', 'TruckAllocation@index')->name('halaman.truckallocation.index');
    Route::get('/{id}', 'TruckAllocation@allocation_detail')->name('halaman.truckallocation.detail');
});

Route::prefix('index')->group(function () {
    Route::get('call_truck', 'TruckAllocation@method_truck');
    Route::get('call_consigne', 'TruckAllocation@method_consignee');
    Route::get('call_driver', 'TruckAllocation@method_driver');
    Route::get('call_routes', 'TruckAllocation@method_routes');
    Route::get('call_logout', 'Dashboard@method_logout');
});
