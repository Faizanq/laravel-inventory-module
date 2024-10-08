<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // Adjust authorization logic as needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255',
        ];

        $id = $this->route('product');

        if ($id) {
            // Editing an existing product
            $rules['sku'] .= '|unique:products,sku,' . $id;
        } else {
            // Adding a new product
            $rules['sku'] .= '|unique:products,sku';
        }

        return $rules;
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'product name',
            'sku' => 'SKU',
        ];
    }
}
