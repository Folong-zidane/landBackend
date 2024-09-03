<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminActionRequest extends FormRequest
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
            'admin_id' => 'required|exists:users,id',
            'action' => 'required|string',
            'description' => 'nullable|string',
            'action_date' => 'required|date',
        ];
    }
}
