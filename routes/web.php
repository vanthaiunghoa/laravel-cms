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

Route::group(['prefix' => '/admin'], function (){
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

//    Route::group(['middleware' => ['auth','role:admin,kill']],function (){
//        Route::get('/', 'Admin\AdminController@index');
//    });
    Route::group(['middleware' => 'auth'], function()
    {
        Route::resource('posts','Admin\PostsController');
        Route::group(['prefix' => '/posts'],function(){
            Route::get('/deleted-posts', 'Admin\PostsController@deleted');
            Route::post('/action', 'Admin\PostsController@action');
            Route::get('/{id}/approve','Admin\PostsController@approve')->name('posts.approve');
            Route::get('/{id}/hide','Admin\PostsController@hide')->name('posts.hide');
            Route::get('/{id}/destroy', 'Admin\PostsController@destroy')->name('posts.destroy');
            Route::get('/{id}/trash', 'Admin\PostsController@trash')->name('posts.trash');
        });
        /*
         * Artisan route:list makes the controller routes and then you only have to use one Route function.
         *  Route::resource('posts','Admin\PostsController');
         posts.store
         posts.index
         posts.destroy
         posts.update
         posts.show
         posts.edit
        */
    });
    Route::group(['middleware' => 'auth'],function(){
        Route::resource('comments','Admin\CommentsController');
        Route::group(['prefix' => '/comments'],function(){
            Route::post('/action','Admin\CommentsController@action');
            Route::get('/{id}/approve','Admin\CommentsController@approve')->name('comments.approve');
            Route::get('/{id}/hide','Admin\CommentsController@hide')->name('comments.hide');
            Route::get('/{id}/destroy','Admin\CommentsController@destroy')->name('comments.destroy');
            Route::get('/{id}/trash','Admin\CommentsController@trash')->name('comments.trash');
        });
    });

    Route::group(['middleware' => 'auth'],function(){
        Route::resource('replies','Admin\RepliesController');
        Route::group(['prefix'=> '/replies'],function(){
            Route::post('/action','Admin\RepliesController@action');
            Route::get('/{id}/approve','Admin\RepliesController@approve')->name('replies.approve');
            Route::get('/{id}/hide','Admin\RepliesController@hide')->name('replies.hide');
            Route::get('/{id}/destroy','Admin\RepliesController@destroy')->name('replies.destroy');
        });
    });

    Route::group(['middleware' => 'auth'], function() {
        Route::resource('categories','Admin\CategoriesController');
        Route::group(['prefix' => '/categories'],function(){
            Route::get('/deleted-categories','Admin\CategoriesController@deleted');
            Route::post('/action', 'Admin\CategoriesController@action');
            Route::get('/{id}/approve','Admin\CategoriesController@approve')->name('categories.approve');
            Route::get('/{id}/hide','Admin\CategoriesController@hide')->name('categories.hide');
            Route::get('/{id}/destroy', 'Admin\CategoriesController@destroy')->name('categories.destroy');
            Route::get('/{id}/trash', 'Admin\CategoriesController@trash')->name('categories.trash');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('tags','Admin\TagsController',['except' => ['show']]);
        Route::group(['prefix' => '/tags'],function(){
            Route::post('/action', 'Admin\TagsController@action');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('users','Admin\UsersController',['except' => ['destroy']]);
        Route::group(['prefix' => '/users'],function(){
            Route::get('/deleted-users', 'Admin\UsersController@deleted');
            Route::post('/action', 'Admin\UsersController@action');
            Route::get('/{id}/approve','Admin\UsersController@approve')->name('users.approve');
            Route::get('/{id}/hide','Admin\UsersController@hide')->name('users.hide');
            Route::get('/{id}/destroy', 'Admin\UsersController@destroy')->name('users.destroy');
            Route::get('/{id}/trash', 'Admin\UsersController@trash')->name('users.trash');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('roles','Admin\RolesController');
        Route::group(['prefix' => '/roles'],function(){
            Route::get('/deleted-roles', 'Admin\RolesController@deleted');
            Route::post('/action', 'Admin\RolesController@action')->name('roles.action');
            Route::get('/{id}/approve','Admin\RolesController@approve')->name('roles.approve');
            Route::get('/{id}/hide','Admin\RolesController@hide')->name('roles.hide');
            Route::get('/{id}/destroy', 'Admin\RolesController@destroy')->name('roles.destroy');
            Route::get('/{id}/trash', 'Admin\RolesController@trash')->name('roles.trash');
        });
    });
    Route::group(['middleware' => 'auth'], function(){
        /* Permissions */
        Route::resource('permissions','Admin\PermissionsController');
        Route::group(['prefix' => '/permissions'],function(){
            Route::get('/deleted-permissions', 'Admin\PermissionsController@deleted');
            Route::post('/action', 'Admin\PermissionsController@action')->name('permissions.action');
            Route::get('/{id}/approve','Admin\PermissionsController@approve')->name('permissions.approve');
            Route::get('/{id}/hide','Admin\PermissionsController@hide')->name('permissions.hide');
            Route::get('/{id}/destroy', 'Admin\PermissionsController@destroy')->name('permissions.destroy');
            Route::get('/{id}/trash', 'Admin\PermissionsController@trash')->name('permissions.trash');
        });
    });

    Route::group(['prefix' => 'pages','middleware' => 'auth'], function(){
       Route::get('/','Admin\PagesController@index');
       Route::get('/add','Admin\PagesController@add');
       Route::get('/new','Admin\PagesController@edit');
       Route::get('/edit/{page}/{title}','Admin\PagesController@edit');
       Route::get('/update/{page}/{title}','Admin\PagesController@update');
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('uploads','Admin\UploadsController',['except' => 'show','destroy']);
        Route::group(['prefix'=>'/uploads'],function(){
            Route::get('/{id}/destroy', 'Admin\UploadsController@destroy')->name('uploads.destroy');
            Route::post('/action', 'Admin\UploadsController@action');
        });
    });
    Route::group(['middleware' => 'auth'],function(){
        Route::resource('folders','Admin\FoldersController',['except' => 'destroy']);
        Route::group(['prefix'=>'/folders'],function(){
            Route::get('/{id}/destroy', 'Admin\FoldersController@destroy')->name('folders.destroy');
            Route::post('/action', 'Admin\FoldersController@action')->name('folders.action');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('products','Admin\ProductsController',['except' => ['show']]);
        Route::group(['prefix' => '/products'],function(){
            Route::get('/deleted-products','Admin\ProductsController@deleted');
            Route::post('/action', 'Admin\ProductsController@action');
            Route::get('/{id}/approve','Admin\ProductsController@approve')->name('products.approve');
            Route::get('/{id}/hide','Admin\ProductsController@hide')->name('products.hide');
            Route::get('/{id}/destroy', 'Admin\ProductsController@destroy')->name('products.destroy');
            Route::get('/{id}/trash', 'Admin\ProductsController@trash')->name('products.trash');
        });
    });

    Route::group(['middleware' => 'auth'], function(){
        Route::resource('contacts','Admin\ContactsController',['except' => ['show']]);
        Route::group(['prefix' => '/contacts'],function(){
            Route::get('/deleted-contacts','Admin\ContactsController@deleted');
            Route::post('/action', 'Admin\ContactsController@action');
        });
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



Auth::routes();

Route::get('/home', 'HomeController@index');