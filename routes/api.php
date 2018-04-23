<?php

use Illuminate\Http\Request;

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

// Route to create a new role
Route::post('role', 'JwtAuthenticateController@createRole');
// Route to create a new permission
Route::post('permission', 'JwtAuthenticateController@createPermission');
// Route to assign role to user
Route::post('assign-role', 'JwtAuthenticateController@assignRole');
// Route to attache permission to a role
Route::post('attach-permission', 'JwtAuthenticateController@attachPermission');

// API route group that we need to protect
Route::group(['prefix' => 'v1', 'middleware' => ['ability:admin,create-users']], function()
{
    // Protected route
    Route::get('users', 'JwtAuthenticateController@index');
});

// Authentication route
Route::post('authenticate', 'JwtAuthenticateController@authenticate');



$rotuesEntityData = function () {
    Route::get('/order/{id}', 'orderController@fetch');
    Route::put('/order/repeat/{id}', 'orderController@reOrder');
    Route::put('/order/close/{id}', 'orderController@closeOrder');
    Route::delete('/order/{id}', 'orderController@delete');
    Route::put('/order/approval/{id}', 'orderController@orderApproval');

    
    Route::get('/delivery/{id}', 'DeliveryController@fetch');
    Route::put('/delivery/repeat/{id}', 'DeliveryController@delivery');
    Route::put('/delivery/{id}', 'DeliveryController@delivery');    
    Route::put('/delivery/close/{id}', 'DeliveryController@closedelivery');
    Route::delete('/delivery/{id}', 'DeliveryController@delete');
    Route::put('/delivery/approval/{id}', 'DeliveryController@deliveryApproval');

    
    Route::get('/hook/{id}', 'hooksController@fetch');
    Route::delete('/hook/{id}', 'hooksController@delete');
    Route::post('/hook', 'hooksController@create');


    Route::get('/spk/{id}', 'spkController@fetch');
    Route::post('/spk', 'spkController@create');
    Route::post('/detail-spk', 'itemWasteController@addWaste');
};

$rotuesCollectionData = function () {
    Route::get('/spk', 'spkController@fetchAll');
    Route::post('/spk', 'spkController@searchByDate');
    Route::get('/spk/filter', 'spkController@filterByHook');
    Route::get('/detail-spk', 'itemWasteController@fetchAllWaste');
    Route::get('/detail-spk/{id}', 'itemWasteController@fetchWaste');
    Route::get('/detail-spk/{id}/filter', 'itemWasteController@filterByCategory');
    
    Route::get('/hook/{group?}', 'hooksController@fetchAll');
    
    Route::get('/order/{status?}', 'orderController@fetchAll');
    Route::post('/order', 'orderController@create');
    
    Route::get('/delivery/{status?}', 'DeliveryController@fetchAll');
};

Route::middleware(['ability:admin,create-users'])->prefix('collection')->group($rotuesCollectionData);
Route::middleware(['ability:admin,create-users'])->prefix('entity')->group($rotuesEntityData);