<?php

use Illuminate\Support\Facades\Route;

Route::view('/', 'sciice::base');
Route::get('script/{name}', 'ResourcesController@script');
Route::get('style/{name}', 'ResourcesController@style');
Route::get('component/{name}', 'ResourcesController@component');

Route::post('login', 'LoginController@login');
Route::post('logout', 'LoginController@logout');

Route::get('initialize', 'HomeController@index');
Route::post('update', 'HomeController@user');
Route::post('avatar', 'HomeController@avatar');

Route::middleware(['sciice.auth:sciice', 'authorize:sciice'])->group(function () {
    Route::apiResources([
        'user'      => 'SciiceController',
        'role'      => 'RoleController',
        'authorize' => 'AuthorizeController',
    ]);
});
