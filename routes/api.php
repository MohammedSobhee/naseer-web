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
    Route::get('sub_services/{service_id}', 'LookUpController@getSubServices');
    Route::get('sub_service/{id}', 'LookUpController@getSubService');

    Route::group(['middleware' => ['auth:api']], function () {

        Route::put('mobile', 'UserController@putUserMobile');
//        Route::put('profile', 'UserController@putProfile');
        Route::get('profile/{id?}', 'UserController@getProfile');

        Route::get('offer/{id}', 'OfferController@show');

        Route::post('contact-us', 'UserController@contactUs');
        Route::group(['middleware' => ['service_provider']], function () {

            Route::post('offer', 'OfferController@create');
            Route::put('complete_service_provider', 'UserController@completeServiceProvider');
            Route::post('order_clients', 'OrderController@getOrderClients');
        });

        Route::group(['middleware' => ['client']], function () {

            Route::get('order/{id}/edit', 'OrderController@getEditOrder');
            Route::put('order/{id}', 'OrderController@putOrder');
            Route::post('order', 'OrderController@postOrder');
            Route::delete('order/{id}', 'OrderController@delete');
            Route::put('order_status', 'OrderController@changeStatus');
            Route::put('offer_status', 'OfferController@changeStatus');
            Route::post('rate', 'RateController@create');

        });

        Route::put('contract', 'ContractController@editContract');

        Route::put('profile', 'UserController@putUser');

        Route::post('service_providers', 'UserController@getServiceProviders');

        Route::post('offers', 'OfferController@getOffers');
        Route::post('orders', 'OrderController@getOrders');

        Route::get('order/{order_id}', 'OrderController@getOrder');
        Route::post('logout', 'UserController@logout');


        Route::post('notifications', 'NotificationController@getNotifications');
        Route::post('refresh_fcm_token', 'NotificationController@refreshFcmToken');
        Route::delete('notification', 'NotificationController@delete');
        Route::post('chat-notify', 'NotificationController@postChatNotification');
        Route::get('unseen-notification', 'NotificationController@getUnseenNotification');


    });
    Route::group(['middleware' => 'authGuest:api'], function () {

    });
});
