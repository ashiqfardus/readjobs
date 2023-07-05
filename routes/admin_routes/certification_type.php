<?php

/* * ******  Certification Type Start ********** */
Route::get('list-certification-types', array_merge(['uses' => 'Admin\CertificationTypeController@indexCertificationTypes'], $all_users))->name('list.certification.types');
Route::get('create-certification-type', array_merge(['uses' => 'Admin\CertificationTypeController@createCertificationType'], $all_users))->name('create.certification.type');
Route::post('store-certification-type', array_merge(['uses' => 'Admin\CertificationTypeController@storeCertificationType'], $all_users))->name('store.certification.type');
Route::get('edit-certification-type/{id}', array_merge(['uses' => 'Admin\CertificationTypeController@editCertificationType'], $all_users))->name('edit.certification.type');
Route::put('update-certification-type/{id}', array_merge(['uses' => 'Admin\CertificationTypeController@updateCertificationType'], $all_users))->name('update.certification.type');
Route::delete('delete-certification-type', array_merge(['uses' => 'Admin\CertificationTypeController@deleteCertificationType'], $all_users))->name('delete.certification.type');
Route::get('fetch-certification.types', array_merge(['uses' => 'Admin\CertificationTypeController@fetchCertificationTypesData'], $all_users))->name('fetch.data.certification.types');
Route::put('make-active-certification-type', array_merge(['uses' => 'Admin\CertificationTypeController@makeActiveCertificationType'], $all_users))->name('make.active.certification.type');
Route::put('make-not-active-certification-type', array_merge(['uses' => 'Admin\CertificationTypeController@makeNotActiveCertificationType'], $all_users))->name('make.not.active.certification.type');
/* * ****** End DegreeType ********** */