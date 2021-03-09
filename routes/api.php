<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'v1'], function () {
    // health
    Route::get('/health', 'MiscsController@siteHealth');

    Route::group(['prefix' => 'betting'], function () {
        Route::post('validation', 'BettingController@inquire');
        Route::post('transact', 'BettingController@transact');
        Route::post('providers', 'BettingController@fetchProviders');

        // callbacks
        Route::post('opay-bet-callback/{reference}', 'BettingController@callback')->name('opay-bet-callback');
        // re-query
        Route::post('status', 'BettingController@requery');

    });
});



