<?php

// User Auth
Auth::routes();
Route::post('password/change', 'UserController@changePassword')->middleware('auth');

// Github Auth Route
Route::group(['prefix' => 'auth/github'], function () {
    Route::get('/', 'Auth\AuthController@redirectToProvider');
    Route::get('callback', 'Auth\AuthController@handleProviderCallback');
    Route::get('register', 'Auth\AuthController@create');
    Route::post('register', 'Auth\AuthController@store');
});

// Search
Route::get('search', 'HomeController@search');

// Landing Page
Route::get('/concurso/assassins-creed', function () {
    return view('landing.assassins-creed');
});

Route::get('/concurso/assassins-creed-success', function () {
    return view('landing.assassins-creed-success');
});

Route::post('concurso/cadastrar', 'LandingPageController@create');

Route::get('/concurso/darth-vader', function () {
    return view('landing.darth-vader');
});

Route::get('/concurso/darth-vader-success', function () {
    return view('landing.darth-vader-success');
});

// Discussion
Route::resource('discussion', 'DiscussionController', ['except' => 'destroy']);

// User
Route::group(['prefix' => 'user'], function () {
    Route::get('/', 'UserController@index');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('profile', 'UserController@edit');
        Route::post('avatar', 'UserController@avatar');
        Route::put('profile/{id}', 'UserController@update');
        Route::post('follow/{id}', 'UserController@doFollow');
    });

    Route::group(['prefix' => '{username}'], function () {
        Route::get('/', 'UserController@show');
        Route::get('comments', 'UserController@comments');
        Route::get('following', 'UserController@following');
        Route::get('discussions', 'UserController@discussions');
    });
});

Route::post('crop/api', 'UserController@cropAvatar')->middleware('auth');

// User Setting
Route::group(['middleware' => 'auth', 'prefix' => 'setting'], function () {
    Route::get('/', 'SettingController@index')->name('setting.index');
    Route::get('binding', 'SettingController@binding')->name('setting.binding');

    Route::get('notification', 'SettingController@notification')->name('setting.notification');
    Route::post('notification', 'SettingController@setNotification');
});

// Link
Route::get('link', 'LinkController@index');

// Category
Route::group(['prefix' => 'category'], function () {
    Route::get('{category}', 'CategoryController@show');
    Route::get('/', 'CategoryController@index');
});

// Tag
Route::group(['prefix' => 'tag'], function () {
    Route::get('/', 'TagController@index');
    Route::get('{tag}', 'TagController@show');
});

/* Dashboard Index */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'admin']], function () {
   Route::get('{path?}', 'HomeController@dashboard')->where('path', '[\/\w\.-]*');
});

// Article
Route::get('/', 'ArticleController@index');
Route::get('{slug}', 'ArticleController@show');



