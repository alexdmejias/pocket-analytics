<?php

Route::get('/', 'PocketController@getHome');

Route::get('/pocket/{q?}', 'PocketController@index');
Route::any('/pocket/store/{key?}', 'PocketController@store');

Route::get('/pocket/articles/{q}', 'PocketController@getPocketArticles');
Route::get('/pocket/total', 'PocketController@getTotalPocketArticles');
Route::get('/pocket/callback', 'PocketController@getCallback');