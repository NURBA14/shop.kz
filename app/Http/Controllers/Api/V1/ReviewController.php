<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Review\ReviewStoreRequest;
use App\Http\Resources\Api\V1\product\ProductShowResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->only("store");
    }
    public function store(ReviewStoreRequest $request, Product $product)
    {        
        $product->reviews()->create([
            "text" => $request->validated("text"),
            "rating" => $request->validated("rating"),
            "user_id" => auth()->user()->id
        ]);
        return response()->json(["product" => new ProductShowResource($product)]);
    }
}
