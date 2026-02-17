<?php

namespace App\Http\Requests\Doctor;

use App\Traits\HasDoctorContext;
use Illuminate\Foundation\Http\FormRequest;

class StoreGrowthVisitRequest extends FormRequest
{
    use HasDoctorContext;
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
       // famaliy_member_id is required and must exist in family_members table
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

    public function messages(): array
    {
        return [
            'family_member_id.required' => 'Family member ID is required.',
            'family_member_id.exists' => 'The specified family member does not exist.',
            'birth_screening_id.required' => 'Birth screening ID is required.',
            'birth_screening_id.exists' => 'The specified birth screening record does not exist.',
            'visit_id.required' => 'Visit ID is required.',
            'visit_id.exists' => 'The specified visit does not exist.',
            'visit_id.unique' => 'A growth visit for this visit ID already exists.',
            'visit_date.required' => 'Visit date is required.',
            'visit_date.date' => 'Visit date must be a valid date.',
            'visit_date.before_or_equal' => 'Visit date cannot be in the future.',
            'age_stage.required' => 'Age stage is required.',
            'age_stage.in' => 'Age stage must be one of the following: under_2_months, 2, 4, 6, 9, 12, 18, 24, 36, 48, 60.',
            // Add more custom messages as needed
        ];
    }
    protected function passedValidation(): void
    {
        $data = $this->validated();
        $age = $data['age_stage'];
        if (in_array($age, ['under_2_months', '2', '4', '6']))
        {
            unset(
                $data['natural_breastfeeding'],
                $data['other_foods'],
                $data['hemoglobin_level']
            );
        }
        elseif ($age == '9')
        {
            unset(
                $data['exclusive_breastfeeding'],
                $data['supplementary_feeding'],
                $data['bottle_feeding'],
                $data['cup_spoon_feeding'],
                $data['hemoglobin_level']
            );
        }
        elseif (in_array($age, ['12', '18', '24']))
        {
            unset(
                $data['exclusive_breastfeeding'],
                $data['supplementary_feeding'],
                $data['bottle_feeding'],
                $data['cup_spoon_feeding']
            );
        }
        elseif (in_array($age, ['36', '48', '60']))
        {
            unset(
                $data['exclusive_breastfeeding'],
                $data['supplementary_feeding'],
                $data['bottle_feeding'],
                $data['cup_spoon_feeding'],
                $data['natural_breastfeeding']
            );
        }
        $doctor = $this->getAuthenticatedDoctor();
        $age = $data['age_stage'];
    }

}
