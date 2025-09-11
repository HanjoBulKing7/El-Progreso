<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BonoAnualStoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'bono' => 'required|numeric|min:0|max:100',
            'year' => 'required|numeric|min:2000|max:5000'
        ];
    }
}
