<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . Auth::id(),
            'email' => 'required|email',
            'introduction' => 'max:80',
            'avatar' => 'mimes:jpeg,bmp,png,gif|dimensions:min_width=208,min_height=208',
        ];
    }

    public function messages()
    {
        return [
            'avatar.mimes' =>'頭像必須是 jpeg, bmp, png, gif 格式的圖片',
            'avatar.dimensions' => '圖片宽和高必須為 208px 以上',
            'name.unique' => '用戶名稱已被使用，請重新填寫',
            'name.regex' => '用戶名稱只能使用英數及橫槓或下底線',
            'name.between' => '用戶名稱必須在 3 - 25 字元之間',
            'name.required' => '用戶名稱不能為空',
        ];
    }
}
