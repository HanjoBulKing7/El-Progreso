<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarNominaRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'mes'           =>  'required',
            'meta_minima'   =>  'required|numeric|min:0|max:999999999',
            'meta_maxima'   =>  'required|numeric|min:0|max:999999999'
        ];
    }
}
