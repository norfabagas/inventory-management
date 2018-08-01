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
Route::get('/register', function () {
  return redirect('login');
});
Route::get('/logout', 'Auth\LoginController@logout');
Route::get('/home', function () {
  return redirect('dashboard');
});
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
    Route::get('/stuff/drop', 'DashboardController@drop');
    // Route::get('/stuff/person', 'DashboardController@person');
    Route::get('/user', 'DashboardController@user')->middleware('isadmin');

    //render json
    // render category
    Route::get('/stuff/category-table', 'CategoryController@table')->name('category');
    Route::resource('/stuff/category-json', 'CategoryController');
    // render Stuff
    Route::get('/stuff-table', 'StuffController@table')->name('stuff');
    Route::resource('/stuff-json', 'StuffController');
    // render Person
    // Route::get('/stuff/person-table', 'PersonController@table')->name('person');
    // Route::resource('stuff/person-json', 'PersonController');
    // Render Drop
    Route::get('/stuff/drop-table', 'DropController@table')->name('drop');
    Route::resource('stuff/drop-json', 'DropController');
    // render person
    Route::get('/user-table', 'UserController@table')->name('user');
    Route::resource('/user-json', 'UserController');

    // render excel
    Route::get('/excel', 'DashboardController@excel')->name('excel');
    Route::get('/excel/stuff/{from}/{to}/{format?}', 'ExcelController@stuff');
    Route::get('/excel/stock/{from}/{to}/{format?}', 'ExcelController@stock');
    Route::get('/excel/drop/{from}/{to}/{format?}', 'ExcelController@drop');
});

Route::get('email', function(){
	\Mail::raw('Sending emails with Mailgun and Laravel is easy!', function($message)
	{
		$message->subject('Laravel are awesome!');
		$message->from('inventory@norfabagas.xyz', 'Website Name');
		$message->to('akunnyagugel@gmail.com');
	});
});
