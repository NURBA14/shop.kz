<?php

namespace App\Http\Resources\Api\V1\category;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryProductListResource extends JsonResource
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
            "description" => $this->description,
            "price" => $this->price,
            "count" => $this->count,
            "brand" => $this->brand->name,
            "created_at" => $this->created_at,
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->name,
            ]
        ];
    }
}
