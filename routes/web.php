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

    Route::group(['prefix' => 'vaksin'], function () {
        Route::get('/', 'Backend\VaksinController@index')->name('vaksin');
        Route::get('create', 'Backend\VaksinController@create')->name('vaksin.create');
        Route::post('store', 'Backend\VaksinController@store')->name('vaksin.store');
        Route::get('edit/{id}', 'Backend\VaksinController@edit')->name('vaksin.edit');
        Route::post('update/{id}', 'Backend\VaksinController@update')->name('vaksin.update');
        Route::get('destroy/{id}', 'Backend\VaksinController@destroy')->name('vaksin.destroy');
    });


    Route::group(['prefix' => 'inventory'], function () {
        Route::get('/', 'Backend\InventoryController@index')->name('inventory');
    });

    
    Route::group(['prefix' => 'inventory-vaksin'], function () {
        Route::get('/', 'Backend\InventoryVaksinController@index')->name('inventory-vaksin');
    });

    Route::group(['prefix' => 'pengeluaran-pakan'], function () {
        Route::get('/', 'Backend\PengeluaranPakanController@index')->name('pengeluaran-pakan');
        Route::get('create', 'Backend\PengeluaranPakanController@create')->name('pengeluaran-pakan.create');
        Route::post('store', 'Backend\PengeluaranPakanController@store')->name('pengeluaran-pakan.store');
        Route::get('edit/{id}', 'Backend\PengeluaranPakanController@edit')->name('pengeluaran-pakan.edit');
        Route::post('update/{id}', 'Backend\PengeluaranPakanController@update')->name('pengeluaran-pakan.update');
        Route::get('destroy/{id}', 'Backend\PengeluaranPakanController@destroy')->name('pengeluaran-pakan.destroy');
    });

    Route::group(['prefix' => 'pengeluaran-vaksin'], function () {
        Route::get('/', 'Backend\PengeluaranVaksinController@index')->name('pengeluaran-vaksin');
        Route::get('create', 'Backend\PengeluaranVaksinController@create')->name('pengeluaran-vaksin.create');
        Route::post('store', 'Backend\PengeluaranVaksinController@store')->name('pengeluaran-vaksin.store');
        Route::get('edit/{id}', 'Backend\PengeluaranVaksinController@edit')->name('pengeluaran-vaksin.edit');
        Route::post('update/{id}', 'Backend\PengeluaranVaksinController@update')->name('pengeluaran-vaksin.update');
        Route::get('destroy/{id}', 'Backend\PengeluaranVaksinController@destroy')->name('pengeluaran-vaksin.destroy');
    });

    Route::group(['prefix' => 'penggunaan-vaksin'], function () {
        Route::get('/', 'Backend\PenggunaanVaksinController@index')->name('penggunaan-vaksin');
        Route::get('create', 'Backend\PenggunaanVaksinController@create')->name('penggunaan-vaksin.create');
        Route::post('store', 'Backend\PenggunaanVaksinController@store')->name('penggunaan-vaksin.store');
        Route::get('edit/{id}', 'Backend\PenggunaanVaksinController@edit')->name('penggunaan-vaksin.edit');
        Route::post('update/{id}', 'Backend\PenggunaanVaksinController@update')->name('penggunaan-vaksin.update');
        Route::get('destroy/{id}', 'Backend\PenggunaanVaksinController@destroy')->name('penggunaan-vaksin.destroy');
    });


    Route::group(['prefix' => 'mix-pakan'], function () {
        Route::get('/', 'Backend\MixPakanController@index')->name('mix-pakan');
        Route::get('create', 'Backend\MixPakanController@create')->name('mix-pakan.create');
        Route::post('store', 'Backend\MixPakanController@store')->name('mix-pakan.store');
        Route::get('edit/{id}', 'Backend\MixPakanController@edit')->name('mix-pakan.edit');
        Route::post('update/{id}', 'Backend\MixPakanController@update')->name('mix-pakan.update');
        Route::get('destroy/{id}', 'Backend\MixPakanController@destroy')->name('mix-pakan.destroy');
    });

    Route::group(['prefix' => 'satuan'], function () {
        Route::get('/', 'Backend\SatuanController@index')->name('satuan');
        Route::get('create', 'Backend\SatuanController@create')->name('satuan.create');
        Route::post('store', 'Backend\SatuanController@store')->name('satuan.store');
        Route::get('edit/{id}', 'Backend\SatuanController@edit')->name('satuan.edit');
        Route::post('update/{id}', 'Backend\SatuanController@update')->name('satuan.update');
        Route::get('destroy/{id}', 'Backend\SatuanController@destroy')->name('satuan.destroy');
    });

    Route::group(['prefix' => 'kandang'], function () {
        Route::get('/', 'Backend\KandangController@index')->name('kandang');
        Route::get('create', 'Backend\KandangController@create')->name('kandang.create');
        Route::post('store', 'Backend\KandangController@store')->name('kandang.store');
        Route::get('edit/{id}', 'Backend\KandangController@edit')->name('kandang.edit');
        Route::post('update/{id}', 'Backend\KandangController@update')->name('kandang.update');
        Route::get('destroy/{id}', 'Backend\KandangController@destroy')->name('kandang.destroy');
    });

    Route::group(['prefix' => 'ternak'], function () {
        Route::get('/', 'Backend\TernakController@index')->name('ternak');
        Route::get('pakan/{id}', 'Backend\TernakController@pakan')->name('ternak.pakan');
        Route::post('simpan-pakan/{id}', 'Backend\TernakController@storePakan')->name('ternak.pakan.store');
        Route::get('create', 'Backend\TernakController@create')->name('ternak.create');
        Route::post('store', 'Backend\TernakController@store')->name('ternak.store');
        Route::get('edit/{id}', 'Backend\TernakController@edit')->name('ternak.edit');
        Route::post('update/{id}', 'Backend\TernakController@update')->name('ternak.update');
        Route::get('destroy/{id}', 'Backend\TernakController@destroy')->name('ternak.destroy');
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
