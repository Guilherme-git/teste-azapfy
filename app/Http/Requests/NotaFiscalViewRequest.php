<?php

namespace App\Http\Requests;

use App\Models\NotaFiscal;
use Illuminate\Foundation\Http\FormRequest;

class NotaFiscalViewRequest extends FormRequest
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
        return [
            'nota' => 'required|gt:0',
        ];
    }

    public function messages()
    {
        return [
            'nota.required' => "É necessário informar o ID da nota",
            'nota.gt' => "O ID deve ser maior que 0",
        ];
    }
}
