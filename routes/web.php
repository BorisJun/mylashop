<?php

Route::get('/', 'PagesController@root')->name('products.index');

Auth::routes();

