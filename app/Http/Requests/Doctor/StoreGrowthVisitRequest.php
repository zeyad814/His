<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreGrowthVisitRequest extends FormRequest
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
        // dd(request()->all());
        return [
            'family_member_id' => 'required|exists:family_members,id',
            "birth_screening_id" => "required|exists:birth_screenings,id",
            "visit_id" => 'required|exists:visits,id|unique:growth_visits,visit_id',
            'visit_date' => 'required|date|before_or_equal:today',
            'age_stage' => 'required|in:under_2_mحonths,2,4,6,9,12,18,24,36,48,60',
            'weight_kg' => 'nullable|numeric|between:0,99.99',
            'height_cm' => 'nullable|numeric|between:0,250',
            'head_circumference_cm' => 'nullable|numeric|between:0,100',
            'use_pacifier' => 'boolean',
            'exclusive_breastfeeding' => 'boolean',
            'supplementary_feeding' => 'boolean',
            'bottle_feeding' => 'boolean',
            'cup_spoon_feeding' => 'boolean',
            'natural_breastfeeding' => 'boolean',
            'other_foods' => 'nullable|string',
            'hemoglobin_level' => 'nullable|numeric|between:0,20',
            'mandatory_vaccinations' => 'boolean',
            'other_vaccinations' => 'nullable|string',
            'vaccination_date' => 'nullable|date',
        ];
    }
}
