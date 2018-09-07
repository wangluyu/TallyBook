<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
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
        $rules = [
            'location' => 'string|max:255',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
        ];
        switch ($this->method()){
            case 'POST':
                $rules['name'] = 'required|string|max:255';
                break;
            case 'PUT':
                $rules['name'] = 'string|max:255';
                $rules['id'] = 'required|integer';
                break;
            case 'DELETE':
                $rules = ['id'  =>  'required|integer'];
                break;
            default:
                return[];
        }
        return $rules;
    }
}
