<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand_id' => 'required|integer|exists:brands,id',
            'category_id' => 'required|integer|exists:categories,id',

            'tags' => 'nullable|array',
            'tags.*' => 'string|exists:tags,name',

            'product_images' => 'required|array|min:1',
            'product_images.*.file' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240', // 10MB max
            'product_images.*.primary' => 'nullable|boolean',
            'product_images.*.position' => 'nullable|integer',

            'variants' => 'required|array|min:1',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.engineer_price' => 'required|numeric|min:0',
            'variants.*.regular_price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.status' => 'required|in:active,inactive',

            'variants.*.attributes' => 'nullable|array',
            'variants.*.attributes.*.key' => 'required|string|max:255',
            'variants.*.attributes.*.value' => 'required|string|max:255',

            'variants.*.images' => 'nullable|array',
            'variants.*.images.*.file' => 'required|file|mimes:jpg,jpeg,png,webp|max:10240',
            'variants.*.images.*.primary' => 'nullable|boolean',
            'variants.*.images.*.position' => 'nullable|integer',
        ];
    }

}
