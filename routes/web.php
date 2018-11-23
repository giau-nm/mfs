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
| Middleware options can be located in `app/Http/Kernel.php`
|
*/

// Authentication Routes
Auth::routes();

// Public Routes
Route::group(['middleware' => ['currentUser']], function () {
    Route::get('/', 'UserController@index')->name('welcome');

    //profile
    Route::get('/profile/edit', 'ProfilesController@edit')->name('profile.edit');
    Route::post('/profile/update/{user_id}', 'ProfilesController@update')->name('profile.update');
});
//
//// Registered and Activated User Routes
//Route::group(['middleware' => ['auth', 'activated', 'activity']], function () {
//
//    // Activation Routes
//    Route::get('/activation-required', ['uses' => 'Auth\ActivateController@activationRequired'])->name('activation-required');
//    Route::get('/logout', ['uses' => 'Auth\LoginController@logout'])->name('logout');
//});
//
//// Registered and Activated User Routes
//Route::group(['middleware' => ['auth', 'activated', 'activity', 'twostep']], function () {
//
//    //  Homepage Route - Redirect based on user role is in controller.
//    Route::get('/home', ['as' => 'public.home',   'uses' => 'UserController@index']);
//    Route::get('/', 'UserController@index')->name('welcome');
//
//    // Show users profile - viewable by other users.
//    Route::get('profile/{username}', [
//        'as'   => '{username}',
//        'uses' => 'ProfilesController@show',
//    ]);
//});
