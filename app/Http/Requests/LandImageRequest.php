<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LandImageRequest extends FormRequest
{
    /**
     * Détermine si l'utilisateur est autorisé à faire cette requête.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Obtient les règles de validation qui s'appliquent à la requête.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'land_id' => 'required|exists:lands,id',
            'url' => 'required|string',
            'caption' => 'nullable|string',
              ];
    }
}
