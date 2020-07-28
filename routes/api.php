<?php


Route::group(['prefix' => 'gift', 'namespace' => 'Gift'], function () {
    Route::get('/plan/{token}/receiver', 'GiftPlanController@getReceiver')
        ->name('api.gift.plan.receiver.get');
});
