<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['prefix' => '/admin','middleware'=> ['web']], function (){
    // Authentication Routes...
    $this->get('/login', 'Admin\Auth\LoginController@showLoginForm')->name('login');
    $this->post('/login', 'Admin\Auth\LoginController@login');
    $this->post('/logout', 'Admin\Auth\LoginController@logout')->name('logout');
    // Registration Routes...
//    $this->get('register', 'Auth\RegisterController@showRegistrationForm');
//    $this->post('register', 'Auth\RegisterController@register');
    // Password Reset Routes...
    $this->get('/password/reset', 'Admin\Auth\ForgotPasswordController@showLinkRequestForm');
    $this->post('/password/email', 'Admin\Auth\ForgotPasswordController@sendResetLinkEmail');
    $this->get('/password/reset/{token}', 'Admin\Auth\ResetPasswordController@showResetForm');
    $this->post('/password/reset', 'Admin\Auth\ResetPasswordController@reset');

    Route::get('/', 'Admin\AdminController@index');

    Route::group(['prefix' => '/posts','middleware' => 'auth'], function()
    {
        Route::get('/', 'Admin\PostsController@index');
        Route::get('/edit/{post}/{title}', 'Admin\PostsController@edit');
        Route::patch('/update/{post}/{title}', 'Admin\PostsController@update');
        Route::get('/new', 'Admin\PostsController@edit');
        Route::put('/add', 'Admin\PostsController@add');
        Route::post('/action', 'Admin\PostsController@action');
    });

    Route::group(['prefix' => '/categories','middleware' => 'auth'], function() {
        Route::get('/', 'Admin\CategoriesController@index');
        Route::put('/add', 'Admin\CategoriesController@add');
        Route::get('/new', 'Admin\CategoriesController@edit');
        Route::get('/edit/{category}/{title}','Admin\CategoriesController@edit');
        Route::patch('/update/{category}/{title}','Admin\CategoriesController@update');
    });

    Route::group(['prefix' => 'users','middleware' => 'auth'], function(){
        Route::get('/', 'Admin\UsersController@index');
        Route::put('/add', 'Admin\UsersController@add');
        Route::get('/new', 'Admin\UsersController@edit');
        Route::get('/edit/{user}','Admin\UsersController@edit');
        Route::patch('/update/{user}/{username}','Admin\UsersController@update');
    });

    Route::group(['prefix' => 'pages','middleware' => 'auth'], function(){
       Route::get('/','Admin\PagesController@index');
       Route::get('/add','Admin\PagesController@add');
       Route::get('/new','Admin\PagesController@edit');
       Route::get('/edit/{page}/{title}','Admin\PagesController@edit');
       Route::get('/update/{page}/{title}','Admin\PagesController@update');
    });

    Route::group(['prefix' => 'files','middleware' => 'auth'], function(){
        Route::get('/','Admin\FilesController@index');
        Route::get('/add','Admin\FilesController@add');
        Route::get('/new','Admin\FilesController@edit');
        Route::get('/edit/{file}/{name}','Admin\FilesController@edit');
        Route::get('/update/{file}/{name}','Admin\FilesController@update');
        Route::auth();
    });

    Route::get('/cards', 'Cards@index');
    Route::get('/cards/{card}', 'Cards@show');

    Route::post('/cards/{card}/notes', 'Notes@store');
    Route::get('/notes/{note}/edit','Notes@edit');
    Route::patch('/notes/{note}','Notes@update');

});

Route::get('/', 'pages@home');

Route::get('/about','pages@about');
Route::get('/skills','pages@skills');

Route::get('/blog', 'Posts@index');
Route::get('/blog/{post}', 'Posts@show');

Route::get('/categories', 'Categories@index');
Route::get('/categories/{category}', 'Categories@show');


