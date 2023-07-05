<?php
Route::get('bulk-user-upload', array_merge(['uses' => 'Admin\BulkUploadController@userCreate'], $all_users))->name('bulk.user.create');
Route::post('bulk-user-upload/store', array_merge(['uses' => 'Admin\BulkUploadController@userStore'], $all_users))->name('bulk.user.store');

Route::get('bulk-job-upload', array_merge(['uses' => 'Admin\BulkUploadController@jobCreate'], $all_users))->name('bulk.job.create');
Route::post('bulk-job-upload/store', array_merge(['uses' => 'Admin\BulkUploadController@jobStore'], $all_users))->name('bulk.job.store');

Route::get('bulk-company-upload', array_merge(['uses' => 'Admin\BulkUploadController@companyCreate'], $all_users))->name('bulk.company.create');
Route::post('bulk-company-upload/store', array_merge(['uses' => 'Admin\BulkUploadController@companyStore'], $all_users))->name('bulk.company.store');