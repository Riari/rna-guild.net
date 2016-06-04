<?php

// Auth
$r->group(['prefix' => 'auth'], function ($r) {
    // Registration
    $r->get('register', 'Auth\AuthController@getRegister');
    $r->post('register', 'Auth\AuthController@postRegister');

    // Confirmation
    $r->get(
        'confirm/{token}',
        ['as' => 'auth.get.confirmation', 'uses' => 'Auth\AuthController@getConfirmation']
    );
    $r->post(
        'confirm',
        ['as' => 'auth.post.confirmation', 'uses' => 'Auth\AuthController@postConfirmation']
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

    // Notifications
    $r->get(
        'notifications',
        ['as' => 'notifications', 'uses' => 'User\AccountController@getNotifications']
    );

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

// Articles
$r->group(['prefix' => 'articles', 'as' => 'article.'], function ($r) {
    $r->get(
        '{article}-{title}',
        ['as' => 'show', 'uses' => 'ArticleController@show']
    );
});

// Events
$r->group(['prefix' => 'events', 'as' => 'event.'], function ($r) {
    $r->get('/', 'EventController@index');
    $r->get(
        '{event}-{name}',
        ['as' => 'show', 'uses' => 'EventController@show']
    );
});

// Characters
$r->group(['prefix' => 'characters', 'as' => 'character.'], function ($r) {
    $r->get('/', 'CharacterController@index');
    $r->get(
        '{character}-{name}',
        ['as' => 'show', 'uses' => 'CharacterController@show']
    );
    $r->get(
        'create',
        ['as' => 'create', 'uses' => 'CharacterController@create']
    );
    $r->post(
        'create',
        ['as' => 'store', 'uses' => 'CharacterController@store']
    );
    $r->get(
        '{character}/edit',
        ['as' => 'edit', 'uses' => 'CharacterController@edit']
    );
    $r->patch(
        '{character}',
        ['as' => 'update', 'uses' => 'CharacterController@update']
    );
    $r->delete(
        '{character}',
        ['as' => 'delete', 'uses' => 'CharacterController@delete']
    );
});

// Image gallery
$r->group(['prefix' => 'gallery', 'as' => 'image-album.'], function ($r) {
    $r->get('/', 'ImageAlbumController@index');
    $r->get(
        '{album}-{title}',
        ['as' => 'show', 'uses' => 'ImageAlbumController@show']
    );
    $r->get(
        'create',
        ['as' => 'create', 'uses' => 'ImageAlbumController@create']
    );
    $r->post(
        'create',
        ['as' => 'store', 'uses' => 'ImageAlbumController@store']
    );
    $r->get(
        '{album}/edit',
        ['as' => 'edit', 'uses' => 'ImageAlbumController@edit']
    );
    $r->patch(
        '{album}',
        ['as' => 'update', 'uses' => 'ImageAlbumController@update']
    );
    $r->delete(
        '{album}',
        ['as' => 'delete', 'uses' => 'ImageAlbumController@delete']
    );
});

// Comments
$r->group(['prefix' => 'comments', 'as' => 'comment.'], function ($r) {
    $r->post(
        '{model}/{id}',
        ['as' => 'store', 'uses' => 'CommentController@store']
    );
    $r->get(
        '{comment}/edit',
        ['as' => 'edit', 'uses' => 'CommentController@edit']
    );
    $r->patch(
        '{comment}',
        ['as' => 'update', 'uses' => 'CommentController@update']
    );
    $r->delete(
        '{comment}',
        ['as' => 'delete', 'uses' => 'CommentController@delete']
    );
});

// Tags
$r->get('tagged/{tag}', 'TagController@show');

// Admin
$r->group(['prefix' => 'admin', 'namespace' => 'Admin'], function ($r) {
    // Dashboard
    $r->get('/', 'AdminController@getDashboard');

    // Users
    $r->resource('user', 'UserController');

    // Articles
    $r->resource('article', 'ArticleController');

    // Events
    $r->resource('event', 'EventController');

    // Forum
    $r->group(['prefix' => 'forum', 'namespace' => 'Forum'], function ($r) {
        $r->resource('category', 'CategoryController');
        $r->post(
            'reorder',
            ['as' => 'admin.forum.category.reorder', 'uses' => 'CategoryController@reorder']
        );
    });

    // Resource deletion
    $r->delete(
        '{model}/{id}',
        ['as' => 'admin.resource.delete', 'uses' => 'AdminController@postDeleteResource']
    );
});
