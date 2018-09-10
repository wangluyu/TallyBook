<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;

class FundRequest extends FormRequest
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
        $method = explode('/', $this->path());
        $method = end($method);
        if (hash_equals('check_unpaid', $method)) {
            return [
                'id' => 'required|integer',
                'partner_id' => 'required|integer'
            ];
        }
        return [
            //
        ];
    }
}
