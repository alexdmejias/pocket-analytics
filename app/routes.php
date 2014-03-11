<?php

Route::get('/', 'PocketController@getHome');

Route::any('/pocket/store/{key?}', 'PocketController@store');
Route::get('/pocket/multiple/{q}', 'PocketController@getMultiple');
Route::get('/pocket/articles/{q}', 'PocketController@getPocketArticles');
Route::get('/pocket/total', 'PocketController@getTotalPocketArticles');
Route::get('/pocket/callback', 'PocketController@getCallback');

Route::resource('pocket', 'PocketController');