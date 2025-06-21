<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/language/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'ar'])) {
        abort(400, 'Invalid language');
    }

    Session::put('locale', $locale);
    return redirect()->back();
})->name('language.switch');
