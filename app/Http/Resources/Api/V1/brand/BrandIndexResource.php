<?php

namespace App\Http\Resources\Api\V1\brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandIndexResource extends JsonResource
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
            "products_count" => $this->getProductsCount(),
            "created_at" => $this->created_at
        ];
    }
}
