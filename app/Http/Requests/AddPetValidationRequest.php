<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddPetValidationRequest extends FormRequest
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
            'name'        => ['required', 'string', 'max:255'],
            'Personality' => ['nullable', 'string', 'max:500'],
            'gender'      => ['required', 'in:Male,Female'],
            'whight'      => ['nullable', 'numeric', 'min:0'],
            'type'        => ['nullable', 'string', 'max:255'],
            'status'      => ['required', 'in:healthy,sick,unknown'],
            'categore'    => ['required', 'in:Dogs,Cats,Birds,Other'],
            'description' => ['nullable', 'string'],
            'age'         => ['nullable', 'integer', 'min:0', 'max:150'],
        ];
    }
}
