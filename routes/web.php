<?php


use Illuminate\Foundation\Support\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

/**
 * Looking for routes? no need using tail stack :)
 * Navigate app/Filament/Resources
 */
