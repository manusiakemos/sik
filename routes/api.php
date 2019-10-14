<?php
// route for single page web apps
Route::post('login', 'AuthController@login');

Route::group(['middleware' => ['auth:api']], function () {
//    begin apicontroller route
    Route::get('puskesmas-list', 'ApiController@puskesmasList');
    Route::get('kecamatan', 'ApiController@kecamatanTabalong');
    Route::get('kelurahan', 'ApiController@kelurahanTabalong');
    Route::post('select-pegawai', 'ApiController@selectPegawai');
    Route::post('select-bidan', 'ApiController@selectBidan');
    Route::post('select-status', 'ApiController@selectStatus');
//    end api cotnroller route
    Route::get('home', 'HomeController@home');
    Route::get('test', 'HomeController@test');

    Route::resource('pregnancyprocess', 'PregnancyProcessController')->except(['edit', 'create']);
    Route::resource('pregnancyprocessdetail', 'PregnancyProcessDetailController')->except(['edit', 'create']);

    Route::group(['middleware' => ['role:kominfo']], function () {
        Route::resource('user', 'UserController')->except(['show', 'update']);
        Route::resource('bidan', 'BidanController')->except(['edit', 'create']);
        Route::resource('puskesmas', 'PuskesmasController')->except(['edit', 'create']);
        Route::resource('reward', 'RewardController')->except(['edit', 'create', 'destroy']);
        Route::get('reward-bidan/history', 'RewardController@history')->name('reward-bidan-history');
        Route::get('reward-bidan/get-history/{page}/{bidan_id}', 'RewardController@getHistory')->name('reward-bidan-get-history');
        Route::get('reward-bidan/{bidan_id}', 'RewardController@rewardBidan')->name('reward-bidan');
        Route::get('reward-poin-bidan/cash/{bidan_id}', 'RewardController@cash')->name('reward-poin-cash');
        Route::get('reward-poin-bidan/balance/{bidan_id}', 'RewardController@balance')->name('reward-poin-balance');
    });

    Route::resource('setting', 'SettingController')->except(['edit', 'create']);
    Route::get('profile', 'ProfileController@edit')->name('profile.edit');
    Route::put('profile', 'ProfileController@update')->name('profile.update');
    Route::post('profile', 'ProfileController@avatar')->name('profile.avatar');

});