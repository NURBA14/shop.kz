<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Brand\BrandStoreRequest;
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
    public function show(string $id)
    {
        return response()->json(["brand" => new BrandShowResource(Brand::findOrFail($id))]);
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
    public function destroy(string $id)
    {
        //
    }
}
