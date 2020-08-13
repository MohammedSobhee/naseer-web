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
});
