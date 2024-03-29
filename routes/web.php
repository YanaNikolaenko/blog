<?php

use App\Http\Controllers\Admin\CategoriesController;
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

Route::get('/admin', [CategoriesController::class, 'index'])->name('admin.index');

Route::get('/admin/categories/create', 'App\Http\Controllers\Admin\CategoriesController@create')->name('admin.categories.create');
Route::post('/admin/categories/store', 'App\Http\Controllers\Admin\CategoriesController@store')->name('admin.categories.store');



//Route::resource('/admin/categories', 'App\Http\Controllers\Admin\CategoriesController');
