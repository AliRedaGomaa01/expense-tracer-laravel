<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    # Seed Test User Using Path
    \App\Models\User::create([
        'name' => 'Test',
        'email' => 'test@aly-h.com',
        'verified_at' => now(),
        'password' => bcrypt('Test123$$'),
    ]);

    return "User created successfully.";
    // return "App is live.";
});
