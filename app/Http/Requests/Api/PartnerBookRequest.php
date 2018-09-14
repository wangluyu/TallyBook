<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class PartnerBookRequest extends FormRequest
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
                $rules = [
                    'book_id' => 'required|integer',
                    'partners' => 'string|nullable|max:255'
                ];
                break;
            case 'DELETE':
                $rules = [
                    'book_id' => 'required|integer',
                    'partner_id' => 'required|integer'
                ];
                break;
            default:
                $rules = [];
        }
        return $rules;
    }
}
