<?php

use App\Http\Controllers\Api\V1\BrandController;
use Illuminate\Support\Facades\Route;

Route::apiResources([
    "brands" => BrandController::class,
]);