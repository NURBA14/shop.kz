<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\ProductStoreRequest;
use App\Http\Resources\Api\V1\product\ProductIndexResource;
use App\Http\Resources\Api\V1\product\ProductShowResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["products" => ProductIndexResource::collection(Product::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        // TODO AUTH-USER
        auth()->login(User::inRandomOrder()->firstOr());
        $product = Auth::user()->products()->create([
            "name" => $request->validated("name"),
            "description" => $request->validated("description"),
            "price" => $request->validated("price"),
            "count" => $request->validated("count"),
            "brand_id" => $request->validated("brand_id"),
            "category_id" => $request->validated("category_id"),
            "is_active" => $request->validated("is_active"),
        ]);
        if($request->file("images")){
            foreach($request->file("images") as $item){
                $folder = date("Y-m-d");
                $path = $item->storePublicly("/images/{$folder}");
                $product->images()->create([
                    "url" => $path
                ]);
            }
        }
        return response()->json(["product" => new ProductShowResource($product)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return response()->json(["product" => new ProductShowResource($product)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
