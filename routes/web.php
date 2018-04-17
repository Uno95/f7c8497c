<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('admin.dashboard');
});

Route::get('/users', function () {
    return view('admin.UserList');
});

Route::get('/add-user', function () {
    return view('admin.CreateNewUser');
});

Route::get('/add-permission', function () {
    return view('admin.CreatePermission');
});

Route::get('/user-roles', function () {
    return view('admin.UserRoleList');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/view-table', 'ExportController@viewTable');
Route::get('/export', 'ExportController@export');