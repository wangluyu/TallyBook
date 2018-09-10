<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            case "POST":
                $rules = [
                    'name' => 'required|string|max:255',
                    'pid' => 'required|integer'
                ];
                break;
            case "PUT":
                $rules = [
                    'name' => 'required|string|max:255',
                    'id' => 'required|integer'
                ];
                break;
            case "DELETE":
                $rules = [
                    'id' => 'required|integer'
                ];
                break;
            default:
                $rules = [];
        }
        return $rules;
    }
}
