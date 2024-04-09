<?php

use App\Http\Controllers\Api\V1\ReviewController;
use Illuminate\Support\Facades\Route;

Route::post("products/{product}/review", [ReviewController::class, "store"])->name("review.store");