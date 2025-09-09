<?php

namespace App\Http\Requests\Student;

use App\Enum\RoleEnum;
use App\Models\Student;
use App\Enum\GenderEnum;
use Illuminate\Validation\Rule;
use App\Enum\EnrollmentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class StudentUpdateRequest extends FormRequest
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
        $student =  Student::find($this->route('id'));
        $userId = $student->user_id ?? null;
        $rules = [];
        // Table User
        $rules['email'] = [];
        $rules['phone'] = [];
        if (request()->has('email'))
            $rules['email'] = ['required', 'email', 'max:255', 'unique:users,email,' . $userId];
        else if (request()->has('phone'))
            $rules['phone'] = ['required', 'string', 'max:255', 'unique:users,phone,' . $userId];
        $rules['first_name'] = ['required', 'string', 'max:30'];
        $rules['middle_name'] = ['required', 'string', 'max:30'];
        $rules['last_name'] = ['required', 'string', 'max:30'];
        $rules['national_number'] = ['required', 'string', 'max:30', 'unique:users,national_number,' . $userId];
        $rules['date_of_birth'] = ['required', 'date'];
        $rules['is_active'] = ['required', 'boolean'];
        $rules['nationality'] = ['nullable', 'string', 'max:30'];
        $rules['role'] = ['required', 'in:' . RoleEnum::STUDENT->value];
        $rules['gender'] = ['required', Rule::enum(GenderEnum::class)];
        $rules['address'] = ['required', 'array'];
        $rules['address.country'] = ['required', 'string', 'max:255'];
        $rules['address.city'] = ['required', 'string', 'max:255'];
        $rules['address.street'] = ['required', 'string', 'max:255'];

        // Table Student
        $rules['roll_number'] = ['nullable', 'string', 'max:30'];
        $rules['blood_type'] = ['nullable', 'string', 'max:30'];
        $rules['emergency_contact'] = ['nullable', 'json', 'max:30'];
        $rules['enrollment_status'] = ['required', Rule::enum(EnrollmentStatusEnum::class)];
        return $rules;
        // $rules['image'] = ['nullable', 'file', 'mimes:jpg,png,jpeg,gif,svg', 'max:2048'];
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
            isset($validated['email']) ? $validated['email'] : null,
            isset($validated['phone']) ? $validated['phone'] : null,
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
