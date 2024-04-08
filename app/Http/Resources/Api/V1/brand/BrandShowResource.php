<?php

namespace App\Http\Resources\Api\V1\brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandShowResource extends JsonResource
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
            "products" => BrandProductListResource::collection($this->products()->active()->get())
        ];
    }
}
