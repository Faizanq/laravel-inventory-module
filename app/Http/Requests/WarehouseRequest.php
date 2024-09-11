<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WarehouseRequest extends FormRequest
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
            'location' => 'required|string|max:255',
        ];

        $id = $this->route('warehouse');

        if ($id) {
            $rules['name'] .= '|unique:warehouses,name,' . $id;
        } else {
            $rules['name'] .= '|unique:warehouses,name';
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
        return [];
    }
}
