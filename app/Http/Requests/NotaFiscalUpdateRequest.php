<?php

namespace App\Http\Requests;

use App\Models\NotaFiscal;
use Illuminate\Foundation\Http\FormRequest;

class NotaFiscalUpdateRequest extends FormRequest
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
            'id' => 'required|gt:0',
            'numero' => 'required|min:9|max:9',
            'valor' => 'required|numeric|gt:0',
            'data_emissao' => 'required|date|before_or_equal:today|date_format:Y-m-d',
            'cnpj_remetente' => 'required|cnpj',
            'nome_remetente' => 'required|max:100',
            'cnpj_transportador' => 'required|cnpj',
            'nome_transportador' => 'required|max:100',
        ];
    }

    public function messages()
    {
        return [
            'id.required' => "É necessário informar o ID da nota",
            'id.gt' => "O ID deve ser maior que 0",
            'numero.required' => "O campo numero é obrigatório",
            'numero.min' => "O campo numero deve conter no mínimo 9 digitos",
            'numero.max' => "O campo numero deve conter no máximo 9 digitos",
            'valor.required' => "O campo valor é obrigatório",
            'valor.numeric' => "O campo valor deve ser um número",
            'valor.gt' => "O campo valor deve ser maior que 0 R$",
            'data_emissao.required' => "O campo data de emissão é obrigatório",
            'data_emissao.date' => "Informe uma data válida",
            'data_emissao.date_format' => "O formato da data de emissão deve ser Y-m-d",
            'data_emissao.before_or_equal' => "A data deve ser uma data anterior ou igual a hoje",
            'nome_remetente.required' => "O campo nome do remetente é obrigatório",
            'nome_remetente.max' => "O nome do remetente deve conter no máximo 100 caracteres",
            'cnpj_transportador.required' => "O campo CNPJ do transportador é obrigatório",
            'nome_transportador.required' => "O campo nome do transportador é obrigatório",
            'nome_transportador.max' => "O nome do transportador deve conter no máximo 100 caracteres",
        ];
    }
}
