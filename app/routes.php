<?php

Route::get('/', 'PocketController@getIndex');
Route::controller('pocket', 'PocketController');
