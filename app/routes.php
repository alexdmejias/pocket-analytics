<?php

Route::get('/', 'PocketController@index');
Route::controller('pocket', 'PocketController');
Route::controller('count', 'CountController');
