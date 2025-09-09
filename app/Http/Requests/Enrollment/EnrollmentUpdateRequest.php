<?php

namespace App\Http\Requests\Enrollment;

use Illuminate\Validation\Rule;
use App\Enum\EnrollmentStatusEnum;
use Illuminate\Foundation\Http\FormRequest;

class EnrollmentUpdateRequest extends FormRequest
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
        $rules['student_id'] = ['required', 'integer', 'exists:students,id', 'unique:enrollments,student_id,' . $this->id];
        $rules['section_id'] = ['required', 'integer', 'exists:sections,id'];
        $rules['academic_year_id'] = ['required', 'integer', 'exists:academic_years,id', 'unique:enrollments,academic_year_id,' . $this->id];
        $rules['grade_id'] = ['required', 'integer', 'exists:grades,id'];
        $rules['admission_date'] = ['nullable', 'date'];
        $rules['status'] = ['required', Rule::enum(EnrollmentStatusEnum::class)];
        $rules['graduation_date'] = ['nullable', 'date'];
        $rules['reason'] = ['nullable', 'string'];
        return $rules;
    }
}
