<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    // return "App is live.";
    Illuminate\Support\Facades\Mail::raw('This is a test email!', function ($message) {
        $message->to('alyredagomaa@gmail.com')->subject('Test Email');
    });

    return response('Test email sent successfully!');
});
