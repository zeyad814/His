<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrowthMeasurementRequest extends FormRequest
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
        return [
            'family_member_id' => 'required|exists:family_members,id',
            'visit_id' => 'required|exists:visits,id',
            'age_months' => 'required|integer|min:0|max:72',
            'head_circumference' => 'required|numeric|between:20,60',
            'weight' => 'required|numeric|between:0.5,50',
            'height' => 'required|numeric|between:30,150',
        ];
    }
}
