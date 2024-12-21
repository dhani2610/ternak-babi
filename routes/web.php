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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/', 'HomeController@redirectAdmin')->name('index');
Route::get('/home', 'HomeController@index')->name('home');

Route::get('/admin/register', 'BerandaController@register')->name('admin-register');
Route::post('/admin/register/store', 'BerandaController@registerStore')->name('admin-register-store');

/**
 * Admin routes
 */
Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Backend\DashboardController@index')->name('admin.dashboard');
    Route::resource('roles', 'Backend\RolesController', ['names' => 'admin.roles']);
    Route::resource('users', 'Backend\UsersController', ['names' => 'admin.users']);
    Route::resource('admins', 'Backend\AdminsController', ['names' => 'admin.admins']);


    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', 'Backend\SupplierController@index')->name('supplier');
        Route::get('create', 'Backend\SupplierController@create')->name('supplier.create');
        Route::post('store', 'Backend\SupplierController@store')->name('supplier.store');
        Route::get('edit/{id}', 'Backend\SupplierController@edit')->name('supplier.edit');
        Route::post('update/{id}', 'Backend\SupplierController@update')->name('supplier.update');
        Route::get('destroy/{id}', 'Backend\SupplierController@destroy')->name('supplier.destroy');
    });



    Route::group(['prefix' => 'pakan'], function () {
        Route::get('/', 'Backend\PakanController@index')->name('pakan');
        Route::get('create', 'Backend\PakanController@create')->name('pakan.create');
        Route::post('store', 'Backend\PakanController@store')->name('pakan.store');
        Route::get('edit/{id}', 'Backend\PakanController@edit')->name('pakan.edit');
        Route::post('update/{id}', 'Backend\PakanController@update')->name('pakan.update');
        Route::get('destroy/{id}', 'Backend\PakanController@destroy')->name('pakan.destroy');
    });



    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', 'Backend\InventoryController@index')->name('inventory');
        Route::get('create', 'Backend\InventoryController@create')->name('inventory.create');
        Route::post('store', 'Backend\InventoryController@store')->name('inventory.store');
        Route::get('edit/{id}', 'Backend\InventoryController@edit')->name('inventory.edit');
        Route::post('update/{id}', 'Backend\InventoryController@update')->name('inventory.update');
        Route::get('destroy/{id}', 'Backend\InventoryController@destroy')->name('inventory.destroy');
    });

    Route::group(['prefix' => 'pengeluaran-pakan'], function () {
        Route::get('/', 'Backend\PengeluaranPakanController@index')->name('pengeluaran-pakan');
        Route::get('create', 'Backend\PengeluaranPakanController@create')->name('pengeluaran-pakan.create');
        Route::post('store', 'Backend\PengeluaranPakanController@store')->name('pengeluaran-pakan.store');
        Route::get('edit/{id}', 'Backend\PengeluaranPakanController@edit')->name('pengeluaran-pakan.edit');
        Route::post('update/{id}', 'Backend\PengeluaranPakanController@update')->name('pengeluaran-pakan.update');
        Route::get('destroy/{id}', 'Backend\PengeluaranPakanController@destroy')->name('pengeluaran-pakan.destroy');
    });

    Route::group(['prefix' => 'mix-pakan'], function () {
        Route::get('/', 'Backend\MixPakanController@index')->name('mix-pakan');
        Route::get('create', 'Backend\MixPakanController@create')->name('mix-pakan.create');
        Route::post('store', 'Backend\MixPakanController@store')->name('mix-pakan.store');
        Route::get('edit/{id}', 'Backend\MixPakanController@edit')->name('mix-pakan.edit');
        Route::post('update/{id}', 'Backend\MixPakanController@update')->name('mix-pakan.update');
        Route::get('destroy/{id}', 'Backend\MixPakanController@destroy')->name('mix-pakan.destroy');
    });


    // Login Routes
    Route::get('/login', 'Backend\Auth\LoginController@showLoginForm')->name('admin.login');
    Route::post('/login/submit', 'Backend\Auth\LoginController@login')->name('admin.login.submit');

    // Logout Routes
    Route::post('/logout/submit', 'Backend\Auth\LoginController@logout')->name('admin.logout.submit');

    // Forget Password Routes
    Route::get('/password/reset', 'Backend\Auth\ForgetPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::post('/password/reset/submit', 'Backend\Auth\ForgetPasswordController@reset')->name('admin.password.update');
});
