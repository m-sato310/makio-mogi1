<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
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
            'name' => 'required',
            'brand' => 'nullable|string',
            'description' => 'required|string|max:255',
            'price' => 'required|integer|min:0',
            'condition' => 'required',
            'image_path' => 'required|mimes:jpeg,png',
            'categories' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品の説明を入力してください',
            'description.max' => '商品の説明は255文字以内で入力してください',
            'price.required' => '販売価格を入力してください',
            'price.integer' => '販売価格は数値で入力してください',
            'price.min' => '販売価格は0円以上で入力してください',
            'condition.required' => '商品の状態を選択してください',
            'image_path.required' => '商品画像を選択してください',
            'image_path.mimes' => '商品画像はjpegまたはpng形式のみアップロードできます',
            'categories.required' => 'カテゴリーを1つ以上選択してください',
        ];
    }
}
