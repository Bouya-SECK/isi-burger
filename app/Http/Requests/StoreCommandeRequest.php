<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommandeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'client';
    }

    public function rules(): array
    {
        return [
            'burger_id' => 'required|exists:burgers,id',
            'quantite'  => 'required|integer|min:1|max:10',
        ];
    }

    public function messages(): array
    {
        return [
            'burger_id.required' => 'Le burger est obligatoire.',
            'burger_id.exists'   => 'Ce burger n\'existe pas.',
            'quantite.required'  => 'La quantité est obligatoire.',
            'quantite.integer'   => 'La quantité doit être un nombre entier.',
            'quantite.min'       => 'La quantité minimum est 1.',
            'quantite.max'       => 'La quantité maximum est 10.',
        ];
    }
}
