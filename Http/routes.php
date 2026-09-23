<?php

// The landing page ('/') is wired via APP_HOMEPAGE_CONTROLLER in .env,
// which points core's own '/' route directly at LandingController@index.
// A module route for '/' would be silently overridden by core's route of
// the same URI (core registers routes after modules), so it is not
// declared here.

Route::group(['middleware' => 'web', 'namespace' => 'Modules\MasjidMediaHelpCenter\Http\Controllers'], function () {
    Route::get('/contact', 'ContactController@show')->name('masjidmediahelpcenter.contact.show');
    Route::post('/contact', ['middleware' => 'throttle:5,1', 'uses' => 'ContactController@submit'])->name('masjidmediahelpcenter.contact.submit');
});
