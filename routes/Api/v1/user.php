<?php

use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Support\Facades\Route;


Route::controller(UserController::class)->group(function () {
    Route::post("/login", "login");
    Route::post("/register", "register");
});