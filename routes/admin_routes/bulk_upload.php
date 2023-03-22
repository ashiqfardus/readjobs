<?php
Route::get('bulk-user-upload', array_merge(['uses' => 'Admin\BulkUploadController@userCreate'], $all_users))->name('bulk.user.create');
