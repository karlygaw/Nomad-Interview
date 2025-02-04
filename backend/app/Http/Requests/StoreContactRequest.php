<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'contact_id' => ['required', 'exists:users,id'], // Проверка, что пользователь существует
            'nickname' => ['nullable', 'string', 'max:255'], // Псевдоним (необязательный)
        ];
    }
}