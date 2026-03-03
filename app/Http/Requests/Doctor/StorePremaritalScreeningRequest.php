<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StorePremaritalScreeningRequest extends FormRequest
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
        'family_member_id'          => 'required|exists:family_members,id',
        
        // 1. التاريخ الطبي
        'consanguinity'             => 'required|boolean',
        'hereditary_diseases'       => 'nullable|string|max:1000',
        'infectious_diseases'       => 'nullable|string|max:1000',
        'chronic_diseases'          => 'nullable|string|max:1000',
        'previous_surgeries'        => 'nullable|string|max:1000',
        
        // 2. الفحص الإكلينيكي
        'blood_pressure'            => 'nullable|string|max:20', 
        'pulse'                     => 'nullable|integer|min:30|max:250',
        'weight'                    => 'nullable|numeric|min:1|max:500',
        'height'                    => 'nullable|numeric|min:30|max:300',
        'general_look'              => 'nullable|string|max:500',
        
        // 3. النتائج المعملية
        'blood_group_rh'            => 'nullable|string|max:10',
        'hemoglobin_level'          => 'nullable|string|max:50',
        'blood_sugar'               => 'nullable|string|max:50',
        'hbsag_result'              => 'nullable|string|max:100', 
        'hiv_result'                => 'nullable|string|max:100',   
        
        // 4. التوصيات والإقرارات
        'medical_recommendation'     => 'nullable|string|max:1000',
        'is_referred_to_specialist' => 'required|boolean',
        'patient_informed'          => 'required|boolean',
        'examination_date'          => 'required|date|before_or_equal:today',
        ];
    }
}
