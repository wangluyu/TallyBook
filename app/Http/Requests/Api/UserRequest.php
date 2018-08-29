<?php

namespace App\Http\Requests\Api;

use Dingo\Api\Http\FormRequest;

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
        switch($this->method()) {
            case 'POST':
                return [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email',
                    'phone' => 'required|integer|size:11',
                    'avatar' => 'required|url',
                    'gender' => 'required|integer|size:1',
                    'city' => 'required|string|max:30',
                    'province' => 'required|string|max:30',
                    'country' => 'required|string|max:30',
                    'language' => 'required|string|max:10',
                ];
                break;
            case 'PUT':
                return [
                    'name' => 'string|max:255',
                    'email' => 'email',
                    'phone' => 'integer|size:11',
                    'avatar' => 'url',
                    'gender' => 'integer|size:1',
                    'city' => 'string|max:30',
                    'province' => 'string|max:30',
                    'country' => 'string|max:30',
                    'language' => 'string|max:10',
                ];
                break;
        }
    }

    public function attributes()
    {
        return [
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
        ];
    }
}
