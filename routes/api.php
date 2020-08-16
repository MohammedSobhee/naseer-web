<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['prefix' => version_api()], function () {
    Route::post('forget', 'Auth\ForgotPasswordController@sendResetLinkEmail');
});

Route::group(['prefix' => version_api(), 'namespace' => namespace_api()], function () {

    Route::post('login', 'UserController@access_token');
    Route::post('refresh_token', 'UserController@refresh_token');
    Route::post('user', 'UserController@postUser');
//    Route::put('user', 'UserController@completeSignUp'); //completeSignUp
    Route::put('profile', 'UserController@updateProfile'); //edit profile
    Route::post('confirm_code', 'UserController@postConfirmCode');
    Route::post('resend_confirm_code', 'UserController@resendConfirmCode');
    Route::get('cities', 'LookUpController@getCities');
    Route::get('countries', 'LookUpController@getCountries');
    Route::get('lookups/{type?}', 'LookUpController@getLookUps');
    Route::get('services/{service_type_id?}', 'LookUpController@getServices');
    Route::get('service_provider_types', 'LookUpController@getServiceProviderTypes');

    Route::group(['middleware' => ['auth:api']], function () {

        Route::put('mobile', 'UserController@putUserMobile');
        Route::put('profile', 'UserController@putProfile');
        Route::get('profile/{id?}', 'UserController@getProfile');

        Route::get('offer/{id}', 'OfferController@show');

        Route::group(['middleware' => ['service_provider']], function () {

            Route::post('offer', 'OfferController@create');
            Route::put('complete_service_provider', 'UserController@completeServiceProvider');
        });

        Route::group(['middleware' => ['client']], function () {

            Route::post('order', 'OrderController@postOrder');
            Route::put('order_status', 'OrderController@changeStatus');
            Route::put('offer_status', 'OfferController@changeStatus');
            Route::post('offers', 'OfferController@getOffers');
            Route::post('rate', 'RateController@create');

        });
        Route::post('orders', 'OrderController@getOrders');

        Route::get('sub_services/{service_id}', 'LookUpController@getSubServices');
        Route::get('sub_service/{id}', 'LookUpController@getSubService');
        Route::get('order/{order_id}', 'OrderController@getOrder');
        Route::post('logout', 'UserController@logout');

    });
    Route::group(['middleware' => 'authGuest:api'], function () {

    });
});