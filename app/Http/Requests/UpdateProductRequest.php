<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'brand_id' => 'nullable|integer|exists:brands,id',
            'category_id' => 'nullable|integer|exists:categories,id',
            'product_deleted_images' => 'nullable|array',
            'product_deleted_images.*' => 'integer|exists:images,id',
            'tags' => 'nullable|array',
            'tags.*' => 'string|exists:tags,name',
            'condition' => 'required|string',
            'negotiable' => 'required|boolean',


            'product_images' => 'array',
            'product_images.*.file' => 'nullable|image|max:2048',
            'product_images.*.image_path' => 'nullable|string',

            'variants' => 'array',
            'variants.*.id' => 'nullable|integer|exists:product_variants,id',
            'variants.*.name' => 'required|string|max:255',
            'variants.*.engineer_price' => 'required|numeric|min:0',
            'variants.*.regular_price' => 'required|numeric|min:0',
            'variants.*.stock' => 'required|integer|min:0',
            'variants.*.status' => 'required|string|in:active,inactive',

            'variants.*.images' => 'array',
            'variants.*.images.*.file' => 'nullable|image|max:2048',
            'variants.*.images.*.image_path' => 'nullable|string',
            'variants.*.images.*.id' => 'nullable|integer|exists:images,id',
            'product_images.*.position' => 'nullable|integer|min:0',

            'variants.*.deleted_images' => 'array',
            'variants.*.deleted_images.*' => 'integer|exists:images,id',

            'variants.*.images.*.position' => 'nullable|integer|min:0',

            'variants.*.attributes' => 'array',
            'variants.*.attributes.*.key' => 'required_with:variants.*.attributes|string|max:255',
            'variants.*.attributes.*.value' => 'required_with:variants.*.attributes|string|max:255',

        ];

    }
}
