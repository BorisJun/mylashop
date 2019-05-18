<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes( ['verify' => true] );

Route::get('/', 'PagesController@root')
    ->name('root')
    ->middleware('verified');

