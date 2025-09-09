<?php

namespace App\Http\Requests\AcademicYear;

use Illuminate\Foundation\Http\FormRequest;

class AcademicYearUpdateRequest extends FormRequest
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
        $rules['name'] = ['required', 'string', 'max:255', 'unique:academic_years,name,' . $this->id];
        $rules['start_date'] = ['nullable', 'date'];
        $rules['end_date'] = ['nullable', 'date'];
        $rules['is_active'] = ['required', 'boolean'];
        return $rules;
    }
}
