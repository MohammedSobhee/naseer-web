<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/reset-password', function () {
    return 'Reset password successfully';
});
//
Auth::routes();
//
//Route::get('/home', 'HomeController@index')->name('home');


Route::group(['namespace' => 'Admin\Auth'], function () {

    Route::get('/user/verify/{token}', 'RegisterController@verifyUser');
    Route::get('/user/verify_page', 'RegisterController@verifyingPage');

    Route::prefix('admin')->group(function () {
        Route::get('/login', 'LoginController@showLoginForm')->name('admin.login');
        Route::post('/login', 'LoginController@loginAdmin')->name('admin.login.submit');
        Route::post('/logout', 'LoginController@logout')->name('admin.logout');

        //admin password reset routes
//        Route::post('/password/email', 'ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
//        Route::get('/password/reset', 'ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
//        Route::post('/password/reset', 'ResetPasswordController@reset');
//        Route::get('/password/reset/{token}', 'ResetPasswordController@showResetForm')->name('admin.password.reset');

    });

});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:admin', 'admin'], 'namespace' => 'Admin'], function () {

    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/admins', 'AdminController@index');
    Route::get('/admins/admin-data', 'AdminController@anyData');
    Route::put('/admins/admin-status', 'AdminController@adminStatus');

    Route::delete('admins/{id}', 'AdminController@delete');
    Route::get('admins/{id}/edit', 'AdminController@edit');
    Route::get('admins/create', 'AdminController@create');
    Route::put('admins/{id}/edit', 'AdminController@update');
    Route::post('admins/create', 'AdminController@store');
    Route::post('/admins/export', 'AdminController@export');

    Route::get('/service-providers', 'UserController@providers');
    Route::get('/service-provider', 'UserController@createProvider');
    Route::post('/service-provider', 'UserController@storeProvider');
    Route::get('/service-provider/{id}', 'UserController@editProvider');
    Route::put('/service-provider/{id}', 'UserController@updateProvider');

    Route::get('/users', 'UserController@index');
    Route::get('/users/{id}/view', 'UserController@profile');
    Route::get('/users/user-data/{type}', 'UserController@anyData');
    Route::put('/users/user-verify', 'UserController@verifyPhone');
    Route::put('/users/user-status', 'UserController@userActive');
    Route::put('/users/approval-provider-edits/{id}', 'UserController@confirmUpdateProvider');
    Route::put('/users/reject-provider-edits/{id}', 'UserController@rejectUpdateProvider');
    Route::post('/users/export', 'UserController@export');
    Route::get('/users/contacts', 'UserController@contacts');
    Route::get('/users/contacts-data', 'UserController@anyContactUsData');

    Route::get('/rates', 'RateController@index');
    Route::get('/rates/rate-data', 'RateController@anyData');
    Route::put('/rates/rate-status', 'RateController@rateApproved');
    Route::post('/rates/export', 'RateController@export');

    Route::get('/contracts', 'ContractController@index');
    Route::get('/contracts/contract-data', 'ContractController@anyData');
    Route::get('/contracts/add-contract', 'ContractController@create');
    Route::post('/contracts/add-contract', 'ContractController@store');
    Route::get('/contracts/edit-contract/{id}', 'ContractController@completeContract');
    Route::put('/contracts/edit-contract/{id}', 'ContractController@update');
    Route::post('/contracts/add-field/{contract_id}', 'ContractController@addField');
    Route::post('/contracts/edit-field/{id}', 'ContractController@editField');
    Route::delete('/contracts/delete-field/{contract_id}', 'ContractController@deleteField');
    Route::delete('/contracts/delete-contract/{contract_id}', 'ContractController@delete');

    Route::get('/requests', 'RequestController@index');
    Route::get('/requests/request-data', 'RequestController@anyData');
    Route::get('/requests/{id}', 'RequestController@requestDet');
    Route::post('/requests/export', 'RequestController@export');

    Route::get('/notifications', 'NotificationController@index');
    Route::post('/general-notification/create', 'NotificationController@sendPublicNotification');
    Route::get('/notification-data', 'NotificationController@anyData');
    Route::delete('/notifications/{id}', 'NotificationController@delete');

    Route::get('/requests/{order_id}/offers', 'OfferController@index');
    Route::get('/requests/{order_id}/contract', 'RequestController@getContract');
    Route::get('/offers/offer-data/{order_id}', 'OfferController@anyData');

    Route::get('/settings', 'SettingController@index');
    Route::put('/settings', 'SettingController@update');

    Route::get('/services', 'ServiceController@index');
    Route::get('/services/service-data', 'ServiceController@anyData');
    Route::get('services/{id}/edit', 'ServiceController@edit');
    Route::put('services/{id}/edit', 'ServiceController@update');
    Route::post('/services/export', 'ServiceController@export');

    Route::group(['prefix' => 'constants'], function () {

        Route::get('/service-provider-types', 'ServiceProviderTypeController@index');
        Route::get('/service-provider-types-data', 'ServiceProviderTypeController@anyData');
        Route::get('/service-provider-types/create', 'ServiceProviderTypeController@create');
        Route::post('/service-provider-types/create', 'ServiceProviderTypeController@store');
        Route::get('/service-provider-types/{id}/edit', 'ServiceProviderTypeController@edit');
        Route::put('/service-provider-types/{id}/edit', 'ServiceProviderTypeController@update');
        Route::delete('/service-provider-types/{id}', 'ServiceProviderTypeController@delete');
        Route::post('/service-provider-types/export', 'ServiceProviderTypeController@export');

        Route::get('/intros', 'IntroController@index');
        Route::get('/intros-data', 'IntroController@anyData');
        Route::get('/intros/create', 'IntroController@create');
        Route::post('/intros/create', 'IntroController@store');
        Route::get('/intros/{id}/edit', 'IntroController@edit');
        Route::put('/intros/{id}/edit', 'IntroController@update');
        Route::delete('/intros/{id}', 'IntroController@delete');
        Route::post('/intros/export', 'IntroController@export');

        Route::get('/countries', 'CountryController@index');
        Route::get('/countries-data', 'CountryController@anyData');
        Route::get('/countries/create', 'CountryController@create');
        Route::post('/countries/create', 'CountryController@store');
        Route::get('/countries/{id}/edit', 'CountryController@edit');
        Route::put('/countries/{id}/edit', 'CountryController@update');
        Route::delete('/countries/{id}', 'CountryController@delete');
        Route::post('/countries/export', 'CountryController@export');

        Route::get('/cities', 'CityController@index');
        Route::get('/cities-data', 'CityController@anyData');
        Route::get('/cities/create', 'CityController@create');
        Route::post('/cities/create', 'CityController@store');
        Route::get('/cities/{id}/edit', 'CityController@edit');
        Route::put('/cities/{id}/edit', 'CityController@update');
        Route::delete('/cities/{id}', 'CityController@delete');
        Route::post('/cities/export', 'CityController@export');

    });


});
