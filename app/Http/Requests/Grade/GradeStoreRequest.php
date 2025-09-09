<?php

namespace App\Http\Requests\Grade;

use App\Http\Requests\Section\SectionStoreRequest;
use Illuminate\Foundation\Http\FormRequest;

class GradeStoreRequest extends FormRequest
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
        $rules['name'] = ['required', 'string', 'max:60', 'unique:grades,name'];
        $rules['code'] = ['nullable', 'string', 'max:5', 'unique:grades,code'];
        $rules['description'] = ['nullable', 'string', 'max:255'];
        $rules['order'] = ['required', 'integer'];
        $rules['sections'] = ['nullable', 'array'];
        if (request()->has('sections')) {
            $rulesSection = (new SectionStoreRequest())->rules();
            foreach ($rulesSection as $key => $value) {
                if ($key == 'grade_id')
                    continue;
                $rules['sections.*.' . $key] = $value;
            }
        }

        return $rules;
    }
}
