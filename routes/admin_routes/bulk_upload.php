<?php
Route::get('bulk-user-upload', array_merge(['uses' => 'Admin\BulkUploadController@userCreate'], $all_users))->name('bulk.user.create');
Route::post('bulk-user-upload/store', array_merge(['uses' => 'Admin\BulkUploadController@userStore'], $all_users))->name('bulk.user.store');
