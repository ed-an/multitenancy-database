<?php

Route::get('/', function () {
    return 'tenants';
});

Route::get('company/store', 'Tenant\CompanyController@store' )->name('company.store');
