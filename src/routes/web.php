<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 8/30/2018
 * Time: 5:56 PM
 */

Route::group(['prefix' => 'mpesa/',
    'namespace' => 'Edgetech\MobileMoney\src\Mpesa\Http\Controllers'
], function () {
    Route::get('mobilemoney', 'MpesaController@index');
    Route::get('login', 'MpesaController@index')->name('login');
    Route::post('logout', 'MpesaController@index')->name('logout');
    Route::any('validate', 'MpesaController@validatepayment');
    Route::any('confirmation', 'MpesaController@confirmation');
    Route::any('callback', 'MpesaController@callback');
    Route::any('stk_callback', 'MpesaController@stkcallback');
    Route::any('initiateb2c', 'MpesaController@initiateb2c');
    Route::any('queuetimeout/{section?}', 'MpesaController@timeout');
    Route::any('result/{section?}', 'MpesaController@result');
    Route::any('stk_request', 'StkController@initiatePush');
    Route::any('generatetoken', 'StkController@generatetoken');
    Route::get('stk_status/{id}', 'StkController@stkStatus');
});
Route::group([
    'namespace'=>'Edgetech\MobileMoney\src\AirtelMoney\Http\Controllers'
    ],function (){
    Route::any('airtelquery', 'AirtelController@request');
    Route::any('airtelbalance', 'AirtelController@getbalance');
    Route::any('airtelb2c', 'AirtelController@makepayment');
});