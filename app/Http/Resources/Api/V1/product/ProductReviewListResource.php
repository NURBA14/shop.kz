<?php

namespace App\Http\Resources\Api\V1\product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewListResource extends JsonResource
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
            "text" => $this->text,
            "rating" => $this->rating,
            "user" => [
                "id" => $this->user->id,
                "name" => $this->user->name,
            ],
            "created_at" => $this->created_at
        ];
    }
}
