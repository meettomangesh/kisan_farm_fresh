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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('register', 'API\RegisterController@register');
Route::post('login', 'API\RegisterController@login');
Route::post('getOtp', 'Api\SmsController@getOtp');
Route::post('verifyOtp', 'Api\SmsController@verifyOtp');
// Route::post('getOtp',\Api\SmsController::class . '@getOtp');
Route::post('categories', 'Api\CategoryController@getCategoryList');
Route::post('products', 'Api\ProductsController@getProductList');
Route::post('banners', 'Api\BannersController@getBannerList');
Route::post('pinCodes', 'Api\RegisterController@getPinCodeList');
Route::post('placeOrder', 'Api\OrdersController@placeOrder');
Route::post('updateCustomer', 'API\RegisterController@updateCustomer');
Route::post('orders', 'Api\OrdersController@getOrderList');
Route::post('cancelOrder', 'Api\OrdersController@cancelOrder');
Route::post('orderList', 'Api\OrdersController@getOrderListForDeliveryBoy');
Route::post('changeOrderStatus', 'Api\OrdersController@changeOrderStatus');

Route::post('getAllAddressByUserId', 'Api\UserAddressController@getAllAddressByUserId');
Route::post('saveAddressByUserId', 'Api\UserAddressController@saveAddressByUserId');
Route::post('updateAddressByUserId', 'Api\UserAddressController@updateAddressByUserId');
Route::post('deleteAddressByUserId', 'Api\UserAddressController@deleteAddressByUserId');
Route::post('uploadImage', 'Api\MiscellaneousController@uploadImage');
Route::post('storeDeviceToken', 'Api\RegisterController@storeDeviceToken');

Route::middleware('auth:api')->group( function () {
    // Route::resource('products', 'API\ProductsController');
    // Route::post('updateCustomer', 'API\RegisterController@updateCustomer');



});