<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return ['welcome' => 'Hello World'];
});

Route::get('/token', function () {
    return ['token' => csrf_token()];
});

require __DIR__.'/auth.php';
