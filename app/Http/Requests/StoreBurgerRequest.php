<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBurgerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->role === 'gestionnaire';
    }

    public function rules(): array
    {
        return [
            'nom'          => 'required|string|max:255',
            'prix'         => 'required|numeric|min:0',
            'description'  => 'nullable|string',
            'categorie_id' => 'required|exists:categories,id',
            'stock'        => 'required|integer|min:0',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'actif'        => 'nullable|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'nom.required'          => 'Le nom du burger est obligatoire.',
            'nom.max'               => 'Le nom ne peut pas dépasser 255 caractères.',
            'prix.required'         => 'Le prix est obligatoire.',
            'prix.numeric'          => 'Le prix doit être un nombre.',
            'prix.min'              => 'Le prix ne peut pas être négatif.',
            'categorie_id.required' => 'La catégorie est obligatoire.',
            'categorie_id.exists'   => 'La catégorie sélectionnée n\'existe pas.',
            'stock.required'        => 'Le stock est obligatoire.',
            'stock.integer'         => 'Le stock doit être un nombre entier.',
            'stock.min'             => 'Le stock ne peut pas être négatif.',
            'image.image'           => 'Le fichier doit être une image.',
            'image.mimes'           => 'L\'image doit être en jpg, jpeg, png ou webp.',
            'image.max'             => 'L\'image ne peut pas dépasser 2MB.',
        ];
    }
}
