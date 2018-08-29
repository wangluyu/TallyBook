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
                    'phone' => [
                        'required',
                        'regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/',
                    ],
                    'avatar' => 'required|url',
                    'gender' => 'required|integer|max:2',
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
                    'phone' => ['regex:/^((13[0-9])|(14[5,7])|(15[0-3,5-9])|(17[0,3,5-8])|(18[0-9])|166|198|199|(147))\d{8}$/'],
                    'avatar' => 'url',
                    'gender' => 'integer|max:2',
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


}
