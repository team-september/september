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
        // プロフィール
        Route::group(['prefix' => 'profile'], function (): void {
            Route::get('/', 'ProfileController@index')->name('profile.index');
            Route::get('/edit', 'ProfileController@edit')->name('profile.edit');
            Route::get('/{id}', 'ProfileController@show')->name('profile.show');
            Route::put('/{id}', 'ProfileController@update')->name('profile.update');
        });

        // メンティー申請
        Route::group(['prefix' => 'application'], function (): void {
            Route::get('/', 'ApplicationController@index')->name('application.index');
            Route::post('/', 'ApplicationController@store')->name('application.store');
            Route::post('/update', 'ApplicationController@update')->name('application.update');
        });

        // 1on1スケジュール
        Route::group(['prefix' => 'schedule'], function (): void {
            Route::get('/', 'ScheduleController@index')->name('schedule.index');
            Route::post('/update', 'ScheduleController@update')->name('schedule.update');
            Route::post('/store', 'ScheduleController@store')->name('schedule.store');

            // ajax用エンドポイント
            Route::post('/getAvailability', 'Api\AvailabilityController@getAvailability');
        });

        // 1on1予約
        Route::group(['prefix' => 'reservation'], function (): void {
            Route::get('/index', 'ReservationController@index')->name('reservation.index');
            Route::post('/store', 'ReservationController@store')->name('reservation.store');
            Route::post('/update', 'ReservationController@update')->name('reservation.update');
        });
    }
);
