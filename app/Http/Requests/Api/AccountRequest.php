<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class AccountRequest extends FormRequest
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
//        $method = explode('_',end(explode('/', $this->path())))[0];
        switch ($this->method()){
            case 'POST':
                return[
                    'name' => 'required|string|max:255',
                    'location' => 'required|string|max:255',
                    'partners' => 'required|string|max:255',
                ];
                break;
            default:
                return[];
        }
    }
}
