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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::middleware(['auth', 'web', 'role:admin'])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::resource('penulis', 'AuthorsController');
        Route::resource('buku', 'BooksController');
    });
});



