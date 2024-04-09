<?php

namespace App\Http\Requests\Api\V1\Product;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name" => "required|max:255|string",
            "description" => "nullable|string",
            "price" => "required|numeric",
            "count" => "required|integer",
            "is_active" => "required|integer",
            "brand_id" => "required|integer",
            "category_id" => "required|integer",
            "images.*" => "image"
        ];
    }
}
