<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SupplierRequest extends FormRequest
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
            'email' => 'required|email',
        ];

        // $id = $this->route('supplier');

        // if ($id) {
        //     $rules['email'] .= '|unique:suppliers,email,' . $id;
        // } else {
        //     $rules['email'] .= '|unique:suppliers,email';
        // }

        return $rules;
    }

    /**
     * Get custom attribute names for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [];
    }
}
