<?php

use App\Http\Controllers\UserController;

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

// Landing Page
Route::view('/', 'welcome');

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth
Auth::routes();
Route::get('/user/verify/{token}', 'Auth\RegisterController@verifyUser');

// Home
Route::get('/home', 'HomeController@index')->middleware(['active', 'prevent_back_history'])->name('home');

// User
Route::resource('users', 'UserController')->parameters(['users' => 'id'])->only(['show', 'edit', 'update'])->middleware(['active', 'prevent_back_history', 'equaltoid']);

// Admin
Route::name('admin.')->group(function () {
    Route::group(['prefix' => 'admin', 'middleware' => ['active', 'prevent_back_history']], function () {

        // User
        Route::group(['middleware' => ['permission:create-users', 'role:user-manager,administrator']], function () {
            Route::get('users/create', 'UserController@create')->name('users.create');
            Route::post('users', 'UserController@store')->name('users.store');
        });

        Route::group(['middleware' => ['permission:list-users', 'role:user-manager,administrator']], function () {
            Route::get('users', 'UserController@index')->name('users.index');
            Route::get('users/{id}', 'UserController@show')->name('users.show');
        });

        Route::group(['middleware' => ['permission:edit-users', 'role:user-manager,administrator']], function () {
            Route::get('users/{id}/edit', 'UserController@edit')->name('users.edit');
            Route::match(['PUT', 'PATCH'], 'users/{id}', 'UserController@update')->name('users.update');
        });

        Route::delete('users/{id}', 'UserController@destroy')->name('users.destroy')->middleware(['permission:delete-users', 'role:user-manager,administrator'])->name('users.destroy');

        // Roles Routes
        Route::resource('roles', 'RoleController')->parameters(['roles' => 'id'])->middleware('role:role-manager,administrator');

        // Permissions Routes
        Route::resource('permissions', 'PermissionController')->parameters(['permissions' => 'id'])->middleware('role:permission-manager,administrator');

        // Logins Routes
        Route::get('logins', 'LoginController@index')->middleware('role:administrator,user-manager')->name('logins.index');

        // Admin Routes
        Route::group(['middleware' => 'role:administrator'], function () {
            Route::get('info', 'AdminController@info')->name('info');
            Route::get('environment', 'AdminController@environment')->name('environment');
            Route::view('commands', 'admin.artisan')->middleware('auth')->name('commands');
            Route::post('run', 'AdminController@run_command')->name('run_command');
            Route::view('tinker', 'admin.tinker')->middleware('auth')->name('tinker');
            Route::post('tinker', 'AdminController@run_tinker')->name('runtinker');
        });
    });
});
