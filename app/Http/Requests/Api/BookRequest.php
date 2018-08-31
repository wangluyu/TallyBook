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
        switch ($this->method()){
            case 'POST':
                return[
                    'name' => 'required|string|max:255',
                    'location' => 'string|max:255',
                    'partners' => 'string|max:255',
                    'start' => 'nullable|date',
                    'end' => 'nullable|date',
                ];
                break;
            default:
                return[];
        }
    }
}
