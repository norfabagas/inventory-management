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
Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout');

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/', function () {
    if (auth()->check()) {
      return redirect('dashboard');
    } else {
      return redirect('/login');
    }
});

Route::group(['middleware' => ['auth', 'isadmin']], function () {
    Route::get('/dashboard', function () {
      return view('dashboard.index');
    });
});
