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

Route::get('/login', 'UserController@login')->name('login');
Route::post('/login', 'Auth\LoginController@login')->name('postlogin');

Route::get('logout', 'Auth\LoginController@logout')->name('user.logout');

Route::group(['middleware' => ['normalUser']], function () {
    // Route::get('/account', 'AccountController@list')->name('account.list');
    // Route::get('/account/{$id}', 'AccountController@edit')->name('account.edit');
    // Route::put('/account/{$id}', 'AccountController@update')->name('account.update');
    // Route::post('/account', 'AccountController@create')->name('account.create');
    // Route::post('/account/destroy/{$id}', 'AccountController@destroy')->name('account.destroy');



    Route::get('/', 'HomeController@index')->name('home');
    Route::resource('devices', 'DeviceController')->except(['show']);
    Route::post('/devices/{id}/change-status', 'DeviceController@changeStatus')->name('devices.change-status');
    Route::get('/devices/import', 'DeviceController@import')->name('devices.import');
    Route::get('/devices/import-list', 'DeviceController@importList')->name('devices.importList');
    Route::get('/devices/get-data-csv', 'DeviceController@getDataFileCsv')->name('devices.getDataFileCsv');
    Route::post('/devices/save-data-csv', 'DeviceController@saveDataCsv')->name('devices.save-data-csv');
    Route::post('/devices/show', 'DeviceController@show')->name('devices.show');
    Route::resource('reports', 'ReportController');
    Route::resource('requests', 'RequestController');
    Route::post('requests/info', 'RequestController@info')->name('requests.info');
    Route::post('/users/change-chatwork-id', 'UserController@changeChatworkId')->name('users.change_cw_id');


    Route::resource('requestTypes', 'RequestTypeController');

    Route::resource('criterias', 'CriteriasController');

    Route::resource('ratingLevels', 'RatingLevelsController');

    Route::resource('results', 'ResultsController');

    Route::resource('mistakes', 'MistakesController');

    Route::resource('workgroups', 'WorkgroupsController');

    Route::resource('agents', 'agentsController');

    Route::resource('users', 'UserController');

    Route::resource('account', 'AccountController');

    Route::get('/mark-tool/avg', 'MarkToolController@avg')->name('mark_tool.avg');
    Route::get('/mark-tool/mfs', 'MarkToolController@mfs')->name('mark_tool.mfs');
    Route::get('/check-tool', 'MarkToolController@index')->name('mark_tool.index');

    Route::get('/mark-log', 'MarkToolController@markLog')->name('report.mark_log');
    Route::get('/mark-log-mfs', 'MarkToolController@markLogMfs')->name('report.mark_log_mfs');
    Route::get('/report-avg', 'MarkToolController@reportAvg')->name('report.avg');
    Route::get('/report-mfs', 'MarkToolController@reportMfs')->name('report.mfs');

    Route::get('/profile/edit/{id}', 'UserController@profileEdit')->name('profile.edit');
    Route::post('/profile/edit/{id}', 'UserController@profileUpdate')->name('profile.update');

    Route::get('/password', 'UserController@password')->name('password.edit');
    Route::post('/password', 'UserController@updateUserPassword')->name('password.update');
});

Route::group(['middleware' => ['adminUser']], function () {
    // Route::resource('projects', 'ProjectController');
    // Route::get('/users/form_change_user_permission', 'UserController@formChangeUserPermission')->name('users.formChangeUserPermission');
    // Route::post('/users/post_change_user_permission', 'UserController@postChangeUserPermission')->name('users.postChangeUserPermission');
    // Route::get('/users/{id}/profile', 'UserController@profile')->name('users.profile');
    // Route::resource('configs', 'ConfigController');
});




