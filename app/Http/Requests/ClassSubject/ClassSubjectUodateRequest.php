<?php

namespace App\Http\Requests\ClassSubject;

use Illuminate\Foundation\Http\FormRequest;

class ClassSubjectUodateRequest extends FormRequest
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
        $rules['subject_id'] = ['required', 'integer', 'exists:subjects,id'];
        $rules['grade_id'] = ['required', 'integer', 'exists:grades,id'];
        $rules['section_id'] = ['required', 'integer', 'exists:sections,id'];
        $rules['teacher_id'] = ['required', 'integer', 'exists:users,id'];
        $rules['academic_year_id'] = ['required', 'integer', 'exists:academic_years,id'];
        $rules['semester'] = ['nullable', 'string'];
        return $rules;
    }
}
