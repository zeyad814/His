<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrowthVisitRequest extends FormRequest
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
            'visit_date' => 'required|date',
            'age_stage' => 'required|string|in:under_2_months,2,4,6,9,12,18,24,36,48,60',
            'weight_kg' => 'required|numeric|between:0,100',
            'height_cm' => 'required|numeric|between:0,200',
            'head_circumference_cm' => 'required|numeric|between:0,100',
            'use_pacifier' => 'boolean',
            'exclusive_breastfeeding' => 'boolean',
            'supplementary_feeding' => 'boolean',
            'bottle_feeding' => 'boolean',
            'cup_spoon_feeding' => 'boolean',
            'natural_breastfeeding' => 'boolean',
            'other_foods' => 'nullable|string|max:500',
            'hemoglobin_level' => 'nullable|numeric|between:0,25',
            'mandatory_vaccinations' => 'boolean',
            'other_vaccinations' => 'nullable|string|max:500',
            'vaccination_date' => 'nullable|date',
        ];
    }
}
