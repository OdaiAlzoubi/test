<?php

namespace App\Http\Requests\Subject;

use App\Enum\SubjectTypeEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SubjectStoreRequest extends FormRequest
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
        $rules['code'] = ['required', 'string', 'max:30', 'unique:subjects,code'];
        $rules['name'] = ['required', 'string', 'max:50'];
        $rules['description'] = ['nullable', 'string'];
        $rules['is_active'] = ['required', 'boolean'];
        $rules['is_offered'] = ['required', 'boolean'];
        $rules['prerequisite_required'] = ['required', 'boolean'];
        $rules['grade_id'] = ['required', 'integer', 'exists:grades,id'];
        $rules['type'] = ['required', Rule::enum(SubjectTypeEnum::class)];
        $rules['credit_hours'] = ['required', 'integer'];
        $rules['theory_hours'] = ['required', 'integer'];
        $rules['practice_hours'] = ['required', 'integer'];
        $rules['assessment_weights'] = ['nullable', 'array'];
        $rules['min_passing_score'] = ['required', 'integer'];
        return $rules;
    }
}
