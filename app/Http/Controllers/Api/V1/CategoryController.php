<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Category\CategoryStoreRequest;
use App\Http\Resources\Api\V1\category\CategoryIndexResource;
use App\Http\Resources\Api\V1\category\CategoryShowResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(["categories" => CategoryIndexResource::collection(Category::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryStoreRequest $request)
    {
        $category = Category::create([
            "name" => $request->validated("name")
        ]);
        return response()->json(["category" => new CategoryShowResource($category)], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json(["category" => new CategoryShowResource($category)]);
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
    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(["message" => "success"], 200);
    }
}
