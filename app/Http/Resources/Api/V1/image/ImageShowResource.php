<?php

namespace App\Http\Resources\Api\V1\image;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageShowResource extends JsonResource
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
            "url" => asset($this->url),
            "product" => [
                "id" => $this->product->id,
                "name" => $this->product->name,
                "description" => $this->product->description,
                "price" => $this->product->price,
                "count" => $this->product->count,
                "brand" => $this->product->brand->name,
                "category" => $this->product->category->name,
                "user" => [
                    "id" => $this->product->user->id,
                    "name" => $this->product->user->name,
                ],
            ],
            "created_at" => $this->created_at
        ];
    }
}
