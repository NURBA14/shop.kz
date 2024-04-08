<?php

namespace App\Http\Resources\Api\V1\brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandProductListResource extends JsonResource
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
            "category" => $this->category->name,
            "created_at" => $this->created_at,
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->name,
            ]
        ];
    }
}
