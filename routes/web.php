<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'HomeController@index')->name('home');
Route::get('/auth0/callback', '\Auth0\Login\Auth0Controller@callback')->name('auth0-callback');
Route::get('/login', 'Auth\Auth0IndexController@login')->name('login');
Route::get('/logout', 'Auth\Auth0IndexController@logout')->name('logout')->middleware('auth');

// ログインしないと使えない機能はすべて以下に記載するように
Route::group(
    ['middleware' => ['auth']],
    function (): void {
        Route::get('/profile', 'ProfileController@index')->name('profile.index');
        Route::get('/profile/show/{id}', 'ProfileController@show')->name('profile.show');
        Route::get('/profile/edit', 'ProfileController@edit')->name('profile.edit');
        Route::put('/profile/update/{id}', 'ProfileController@update')->name('profile.update');

        Route::get('/application', 'ApplicationController@index')->name('application.index');
        Route::post('/application', 'ApplicationController@store')->name('application.store');
        Route::post('/application/update', 'ApplicationController@update')->name('application.update');

        Route::group(['prefix' => 'reservation'], function (): void {
            Route::get('', 'ReservationController@index')->name('reservation.index');
            Route::get('/check', 'ReservationController@checkReservationApplication')->name('reservation.check');

            Route::post('/submit', 'ReservationController@reserve')->name('reservation.submit');
            Route::post('/setting', 'ReservationController@setting')->name('reservation.setting');
            Route::post('/setting/update', 'ReservationController@setTime')->name('reservation.setTime');

            // ajax用エンドポイント
            Route::post('/getAvailability', 'Api\AvailabilityController@getAvailability');
            Route::get('/detail', 'ReservationController@reserve')->name('reservation.reserve');

        });
    }
);
