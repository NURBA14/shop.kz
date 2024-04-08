<?php

use App\Http\Controllers\Api\V1\CategoryController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "categories" => CategoryController::class
]);