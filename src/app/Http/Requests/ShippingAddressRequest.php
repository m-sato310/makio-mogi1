<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShippingAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'zipcode' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required|string',
            'building' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'zipcode.required' => '郵便番号を入力してください',
            'zipcode.regex' => '郵便番号はハイフンありの8文字（例：123-4567）で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
