<?php

use Illuminate\Support\Facades\Route;

Route::any('{any}', function () {
    return view('vueApp');
})->where('any', '.*');;