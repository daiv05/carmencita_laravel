<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ActualizarProductoRequest extends FormRequest
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
            'codigo_barra_producto' => [
                'string',
                'max:10',
                Rule::unique('producto')->ignore($this->route('idProducto'),'codigo_barra_producto'),
            ], // El código de barras debe ser único
            'nombre_producto' => 'required|string|max:50',
            'cantidad_producto_disponible' => 'required|integer',
            'precio_unitario' => 'required|decimal:0,2',
            'esta_disponible' => 'required|boolean',
            'foto'=>'image'
        ];
    }
}
