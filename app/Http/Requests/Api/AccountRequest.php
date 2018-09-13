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
        switch ($this->method()){
            case 'POST':
                return[
                    'tag_id' => 'required|string|max:255',
                    'amount'    =>  'required',
                    'pay'   =>  'required|array',
                    'note' => 'string|max:255',
                    'location' => 'string|max:255',
                    'timestamp' => 'string|max:255',
                ];
                break;
            default:
                return[];
        }
    }
}
