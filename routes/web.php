<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

Route::get('/test', function () {
  // return "App is live.";
  Schema::create('expenses', function (Blueprint $table) {
    $table->id();
    $table->string('name', 255)->index();
    $table->decimal('price')->index();
    $table->unsignedBigInteger('date_id')->index();
    $table->unsignedInteger('category_id');
    $table->timestamps();
  });
  Schema::create('dates', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('user_id')->index();
    $table->date('date')->index();
    $table->decimal('expenses_sum')->nullable()->index();
  });
  return "Migrated tables successfully.";
});
