<?php

namespace App\Http\Resources\Api\V1\image;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageIndexResource extends JsonResource
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
                "price" => $this->product->price
            ],
            "created_at" => $this->created_at
        ];
    }
}
