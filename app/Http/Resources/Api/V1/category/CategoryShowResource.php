<?php

namespace App\Http\Resources\Api\V1\category;

use App\Http\Resources\Api\V1\category\CategoryProductListResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "created_at" => $this->created_at,
            "products_count" => $this->getProductsCount(),
            "products" => CategoryProductListResource::collection($this->products)
        ];
    }
}
