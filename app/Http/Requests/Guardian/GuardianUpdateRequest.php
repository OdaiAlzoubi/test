<?php

namespace App\Http\Requests\Guardian;

use App\Enum\RoleEnum;
use App\Enum\GenderEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class GuardianUpdateRequest extends FormRequest
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
        $userId = $this->guardian_user_id;
        $rules = [];
        // Table User
        $rules['email'] = [];
        $rules['phone'] = [];
        if (request()->has('email'))
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email,' . $userId];
        $rules['phone'] = ['required', 'string', 'max:255', 'unique:users,phone,' . $userId];
        $rules['first_name'] = ['required', 'string', 'max:30'];
        $rules['middle_name'] = ['required', 'string', 'max:30'];
        $rules['last_name'] = ['required', 'string', 'max:30'];
        $rules['national_number'] = ['required', 'string', 'max:30', 'unique:users,national_number,' . $userId];
        $rules['date_of_birth'] = ['required', 'date'];
        $rules['is_active'] = ['required', 'boolean'];
        $rules['nationality'] = ['required', 'string', 'max:30'];
        $rules['role'] = ['required', 'in:' . RoleEnum::GUARDIAN->value];
        $rules['gender'] = ['required', Rule::enum(GenderEnum::class)];
        $rules['address'] = ['required', 'array'];
        $rules['address.country'] = ['required', 'string', 'max:255'];
        $rules['address.city'] = ['required', 'string', 'max:255'];
        $rules['address.street'] = ['required', 'string', 'max:255'];

        // Table Guardian
        $rules['student_id'] = ['required', 'exists:students,id'];
        $rules['relation'] = ['nullable', 'string', 'max:255'];
        $rules['is_primary'] = ['required', 'boolean'];
        return $rules;
    }

    public function validated($key = null, $default = null): array
    {
        $validated = parent::validated($key, $default);
        if (is_array($validated) && isset($validated['first_name'], $validated['middle_name'], $validated['last_name'])) {
            $validated['name'] = trim("{$validated['first_name']} {$validated['middle_name']} {$validated['last_name']}");
            unset($validated['first_name'], $validated['middle_name'], $validated['last_name']);
        }
        $validated['user'] = [
            'name' => $validated['name'],
            'email' => isset($validated['email']) ? $validated['email'] : null,
            'phone' => $validated['phone'],
            'national_number' => $validated['national_number'],
            'date_of_birth' => $validated['date_of_birth'],
            'is_active' => $validated['is_active'],
            'address' => $validated['address'],
            'role' => $validated['role'],
            'gender' => $validated['gender'],
        ];
        unset(
            $validated['name'],
            $validated['email'],
            $validated['phone'],
            $validated['national_number'],
            $validated['date_of_birth'],
            $validated['is_active'],
            $validated['address'],
            $validated['role'],
            $validated['gender'],
        );
        return $validated;
    }
}
