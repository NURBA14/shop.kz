<?php

use App\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "products" => ProductController::class,
]);


