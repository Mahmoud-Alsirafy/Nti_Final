<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PersonalDataRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'userId'        => ['nullable', 'integer', 'exists:users,id'],
            'clinicName'    => ['nullable', 'string', 'max:255'],
            'clinicAddress' => ['nullable', 'string', 'max:255'],
            'clinicNumber'  => ['nullable', 'string', 'min:0', 'max:255'],
            'name'          => ['nullable', 'string', 'max:255'],
            'phone'         => ['nullable', 'string', 'max:255'],
            'image'         => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ];
    }
}
