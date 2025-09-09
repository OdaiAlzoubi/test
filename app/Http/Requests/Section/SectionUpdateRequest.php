<?php

namespace App\Http\Requests\Section;

use App\Enum\ShiftEnum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SectionUpdateRequest extends FormRequest
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
        $rules['name'] = ['required', 'string', 'max:30'];
        $rules['capacity'] = ['nullable', 'integer'];
        $rules['room'] = ['nullable', 'string', 'max:30'];
        $rules['shift'] = ['required', Rule::enum(ShiftEnum::class)];
        $rules['grade_id'] = ['required', 'integer', 'exists:grades,id'];
        $rules['is_active'] = ['required', 'boolean'];
        return $rules;
    }
}
