<?php
use Illuminate\Support\Facades\Route;

Route::group(['prefix' =>
    config('navmenu.prefix'),
    'middleware'=>config('navmenu.middleware'),
    'as'=>config('navmenu.as'),
    'namespace' => 'Laravelcity\NavMenu\Controllers'], function () {

   Route::resource('nav','NavController');
    Route::get('/nav/{id}/delete','NavController@destroy')->name('nav.customDelete');
    Route::get('/nav/active/{position}/{id}','NavController@activeNav')->name('nav.active');

   Route::get('/nav/link/remove/id/{id}','LinkController@removeLink')->name('nav.link.remove');
   Route::post('/nav/link/serialize/links/nav-id','NavController@serializeLinks')->name('nav.link.serialize');

   Route::resource('link','LinkController');
   Route::get('/link/search/title/','LinkController@search')->name('nav.link.search');

});


