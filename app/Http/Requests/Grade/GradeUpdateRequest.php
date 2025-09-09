<?php

namespace App\Http\Requests\Grade;

use Illuminate\Foundation\Http\FormRequest;

class GradeUpdateRequest extends FormRequest
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
        $rules['name'] = ['required', 'string', 'max:60', 'unique:grades,name,' . $this->id];
        $rules['code'] = ['nullable', 'string', 'max:5', 'unique:grades,code,' . $this->id];
        $rules['description'] = ['nullable', 'string', 'max:255'];
        $rules['order'] = ['required', 'integer'];
        return $rules;
    }
}
