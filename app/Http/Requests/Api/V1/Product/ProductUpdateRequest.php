<?php

namespace App\Http\Requests\Api\V1\Product;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends ApiRequest
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
            "name" => "nullable|max:255|string",
            "description" => "nullable|string",
            "price" => "nullable|numeric",
            "count" => "nullable|integer",
            "is_active" => "nullable|integer",
            "brand_id" => "nullable|integer",
            "category_id" => "nullable|integer",

        ];
    }
}
