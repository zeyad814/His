<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class FamilyStoreRequest extends FormRequest
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
            'family_code' => 'required|unique:families,family_code',
            'national_id' => 'required|unique:families,national_id|digits:14',
            'head_name' => 'required|string|max:255',
            'governorate' => 'required|string',
            'health_department' => 'required|string',
            'health_unit' => 'required|string',
            'village_or_city' => 'required|string',
            'address' => 'required|string',
            'mobile_phone' => 'required|string',
            'work_phone' => 'nullable|string',
            'nearest_phone' => 'nullable|string',

            // 4. سجل الوفيات
            // 'death_records' => 'nullable|array',
            // 'death_records.*.member_name' => 'required|string',
            // 'death_records.*.death_date' => 'required|date',
            // 'death_records.*.age_at_death' => 'required|integer|min:0',
            // 'death_records.*.cause_of_death' => 'required|string',
            // 'death_records.*.death_code' => 'nullable|string',
        ];
    }
}
