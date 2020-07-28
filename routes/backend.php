<?php

Route::get('gifts', 'GiftController@index')->name('backend.gift.index');
Route::get('gifts/{giftPlan}', 'GiftController@show')->name('backend.gift.show');
Route::post('gifts/status/{giftPlan}', 'GiftController@updateStatus')->name('backend.gift.update.status');

Route::get('users', 'UserController@index')->name('backend.user.index');
Route::get('users/{user}', 'UserController@show')->name('backend.user.show');
Route::get('users/password', 'PasswordController@changePassword')->name('backend.user.change-password');
Route::put('users/password', 'PasswordController@updatePassword')->name('backend.user.update-password');
Route::post('users/{user}', 'UserController@updateStatus')->name('backend.user.status.update');
Route::get('users/{user}/events', 'EventController@index')->name('backend.user.event.index');
Route::get('users/{user}/timeline', 'TimelineController@index')->name('backend.user.timeline.index');
Route::get('users/{user}/wishes', 'WishController@index')->name('backend.user.wishes.index');
Route::get('users/{user}/sent-gift', 'TimelineController@sentGfits')->name('backend.user.sent-gifts.index');
Route::get('users/{user}/received-gift', 'TimelineController@receivedGifts')->name('backend.user.received-gifts.index');
