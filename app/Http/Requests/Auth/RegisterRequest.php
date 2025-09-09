<?php

namespace App\Http\Requests\Auth;

use App\Enum\GenderEnum;
use App\Enum\RoleEnum;
use App\Enum\StatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
        $rules = [];
        if (request()->has('email'))
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email'];
        else
            $rules['phone'] = ['required', 'string', 'max:255', 'unique:users,phone'];
        $rules['first_name'] = ['required', 'string', 'max:30'];
        $rules['middle_name'] = ['required', 'string', 'max:30'];
        $rules['last_name'] = ['required', 'string', 'max:30'];
        $rules['date_of_birth'] = ['required', 'date'];
        $rules['password'] = ['required', 'string', 'confirmed', 'min:8'];
        $rules['role'] = ['required', Rule::enum(RoleEnum::class)];
        $rules['gender'] = ['required', Rule::enum(GenderEnum::class)];
        $rules['is_active'] = ['required', 'boolean'];
        $rules['national_number'] = ['required', 'string', 'max:255', 'unique:users,national_number'];
        $rules['address'] = ['required', 'array'];
        $rules['address.country'] = ['required', 'string', 'max:255'];
        $rules['address.city'] = ['required', 'string', 'max:255'];
        $rules['address.street'] = ['required', 'string', 'max:255'];
        return $rules;
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);
        if (is_array($validated) && isset($validated['first_name'], $validated['middle_name'], $validated['last_name'])) {
            $validated['name'] = trim("{$validated['first_name']} {$validated['middle_name']} {$validated['last_name']}");
            unset($validated['first_name'], $validated['middle_name'], $validated['last_name']);
        }
        return $validated;
    }
}
