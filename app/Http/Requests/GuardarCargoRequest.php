<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuardarCargoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            "id_jornada_laboral_diaria"=>"required",
            "nombre_cargo"=>"required|string|unique:cargo,nombre_cargo",
            "salario_cargo"=>"required|numeric",
            "descripcion_cargo"=>"required|string"
        ];
    }
}
