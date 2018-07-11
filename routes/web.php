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

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth'], function () {
    //render html
    Route::get('/', 'DashboardController@index');
    Route::get('/stuff', 'DashboardController@stuff');
    Route::get('/stuff/category', 'DashboardController@category');
    // Route::get('/stuff/drop', 'DashboardController@drop');
    // Route::get('/stuff/person', 'DashboardController@person');

    //render json
    // render category
    Route::get('/stuff/category-table', 'CategoryController@table')->name('category');
    Route::resource('/stuff/category-json', 'CategoryController');
    // render Stuff
    Route::get('/stuff-table', 'StuffController@table')->name('stuff');
    Route::resource('/stuff-json', 'StuffController');
});
