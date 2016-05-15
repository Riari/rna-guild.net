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

$r->get(
    '/',
    ['as' => 'home', 'uses' => 'HomeController@show']
);
