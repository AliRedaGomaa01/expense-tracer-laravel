<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return "APP is live.";
});

require __DIR__.'/auth.php';
