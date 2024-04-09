<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Brand\BrandStoreRequest;
use App\Http\Requests\Api\V1\Brand\BrandUpdateRequest;
use App\Http\Resources\Api\V1\brand\BrandIndexResource;
use App\Http\Resources\Api\V1\brand\BrandShowResource;
use App\Models\Brand;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        return response()->json(["brands" => BrandIndexResource::collection(Brand::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandStoreRequest $request)
    {
        $brand = Brand::create([
            "name" => $request->validated("name")
        ]);
        return response()->json(["brand" => new BrandShowResource($brand)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Brand $brand)
    {
        return response()->json(["brand" => new BrandShowResource($brand)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandUpdateRequest $request, Brand $brand)
    {
        $brand->update([
            "name" => $request->validated("name")
        ]);
        return response()->json(["brand" => new BrandShowResource($brand)]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->has("products")) {
            return response()->json(["message" => "This brand has products"], 400);
        } else {
            $brand->delete();
            return response()->json(["message" => "success"], 200);
        }
    }
}
