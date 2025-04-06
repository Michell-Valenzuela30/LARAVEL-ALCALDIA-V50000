<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ? $this->route('user')->id : null;

        return match ($this->method()) {
            'POST' => [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:8',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'role' => 'required|exists:roles,name'
            ],
            'PUT', 'PATCH' => [
                'name' => 'sometimes|required|string|max:255',
                'email' => [
                    'sometimes',
                    'required',
                    'email',
                    Rule::unique('users')->ignore($userId)
                ],
                'password' => 'sometimes|string|min:8',
                'direccion' => 'nullable|string|max:255',
                'telefono' => 'nullable|string|max:20',
                'role' => 'sometimes|exists:roles,name'
            ],
            default => []
        };
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'El correo electrónico ya está registrado.',
            'role.exists' => 'El rol seleccionado no es válido.'
        ];
    }
}
