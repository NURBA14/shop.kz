<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Product\ProductStoreRequest;
use App\Http\Requests\Api\V1\Product\ProductUpdateRequest;
use App\Http\Resources\Api\V1\product\ProductIndexResource;
use App\Http\Resources\Api\V1\product\ProductShowResource;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware("auth:sanctum")->only(["store", "update", "destroy"]);
    }
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
        $product = Auth::user()->products()->create([
            "name" => $request->validated("name"),
            "description" => $request->validated("description"),
            "price" => $request->validated("price"),
            "count" => $request->validated("count"),
            "brand_id" => $request->validated("brand_id"),
            "category_id" => $request->validated("category_id"),
            "is_active" => $request->validated("is_active"),
        ]);
        if ($request->file("images")) {
            foreach ($request->file("images") as $item) {
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
    public function update(ProductUpdateRequest $request, Product $product)
    {
        if ($request->method() == "PUT") {
            $product->update([
                "name" => $request->validated("name", null),
                "description" => $request->validated("description", null),
                "price" => $request->validated("price", 0),
                "count" => $request->validated("count", 0),
                "is_active" => $request->validated("is_active", 1),
                "brand_id" => $request->validated("brand_id", 1),
                "category_id" => $request->validated("category_id", 1)
            ]);
            return response()->json(["product" => new ProductShowResource($product)]);
        } elseif ($request->method() == "PATCH") {
            $product->update([
                "name" => $request->validated("name", $product->name),
                "description" => $request->validated("description", $product->description),
                "price" => $request->validated("price", $product->price),
                "count" => $request->validated("count", $product->count),
                "is_active" => $request->validated("is_active", $product->is_active),
                "brand_id" => $request->validated("brand_id", $product->brand_id),
                "category_id" => $request->validated("category_id", $product->category_id)
            ]);
            return response()->json(["product" => new ProductShowResource($product)]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->images->count()) {
            foreach ($product->images as $image) {
                Storage::delete($image->url);
                $image->delete();
            }
        }
        $product->delete();
        return response()->json(["message" => "success"], 200);
    }
}
