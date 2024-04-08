<?php

use App\Http\Controllers\Api\V1\ImageController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "images" => ImageController::class
]);