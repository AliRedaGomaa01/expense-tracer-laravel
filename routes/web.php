<?php

use App\Mail\VerifyEmailTokenMail;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    // \Illuminate\Support\Facades\Mail::to('alyredagomaa@gmail.com')->send(new VerifyEmailTokenMail());
    // return 'email sent successfully';
    return "App is live.";
});
