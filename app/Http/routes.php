<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// Auth
$r->group(['prefix' => 'auth'], function ($r) {
    // Registration
    $r->get('register', 'Auth\AuthController@getRegister');
    $r->post('register', 'Auth\AuthController@postRegister');

    // Activation
    $r->get(
        'activate/{token}',
        ['as' => 'auth.get.activation', 'uses' => 'Auth\AuthController@getActivation']
    );
    $r->post(
        'activate',
        ['as' => 'auth.post.activation', 'uses' => 'Auth\AuthController@postActivation']
    );

    // Login
    $r->get('login', 'Auth\AuthController@getLogin');
    $r->post('login', 'Auth\AuthController@postLogin');
    $r->get('logout', 'Auth\AuthController@getLogout');

    // Password reset
    $r->get('password/reset/{token?}', 'Auth\PasswordController@showResetForm');
    $r->post('password/email', 'Auth\PasswordController@sendResetLinkEmail');
    $r->post('password/reset', 'Auth\PasswordController@reset');

    // Socialite
    $r->get('{provider}', 'Auth\AuthController@redirectToProvider');
    $r->get('{provider}/callback', 'Auth\AuthController@handleProviderCallback');
});

// Account
$r->group(['prefix' => 'account', 'as' => 'account.'], function ($r) {
    // Settings & logins
    $r->get(
        'settings',
        ['as' => 'settings', 'uses' => 'User\AccountController@getSettings']
    );
    $r->post('settings', 'User\AccountController@postSettings');
    $r->get(
        '{provider}/disconnect',
        ['as' => 'disconnect-login', 'uses' => 'User\AccountController@getDisconnectLogin']
    );
    $r->post('{provider}/disconnect', 'User\AccountController@postDisconnectLogin');

    // Profile
    $r->get('profile', 'User\AccountController@redirectToProfile');
    $r->get(
        'profile/edit',
        ['as' => 'profile.edit', 'uses' => 'User\AccountController@getEditProfile']
    );
    $r->post('profile/edit', 'User\AccountController@postEditProfile');
});

// User
$r->group(['prefix' => 'user', 'as' => 'user.'], function ($r) {
    // Profiles
    $r->get(
        '{id}-{name}',
        ['as' => 'profile', 'uses' => 'User\ProfileController@show']
    );
});

// Home
$r->get(
    '/',
    ['as' => 'home', 'uses' => 'HomeController@show']
);

// Admin
$r->group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($r) {
    // Dashboard
    $r->get('/', 'AdminController@getDashboard');

    // Articles
    $r->resource('article', 'ArticleController');

    // Forum
    $r->group(['prefix' => 'forum', 'namespace' => 'Forum'], function ($r) {
        $r->resource('category', 'CategoryController');
    });

    // Resource deletion
    $r->get(
        '{model}/{id}/delete',
        ['as' => 'admin.resource.delete', 'uses' => 'AdminController@getDeleteResource']
    );
    $r->delete('{model}/{id}', 'AdminController@postDeleteResource');
});

// Model binding
$r->model('article', \App\Models\Article::class);
