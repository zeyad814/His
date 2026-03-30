<?php

namespace App\Http\Requests\Doctor;

use Illuminate\Foundation\Http\FormRequest;

class StoreHistoryRequest extends FormRequest
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
            'family_member_id' => 'required|integer|exists:family_members,id',
            // Medical History (Strings)
            'hospitalization' => 'nullable|string',
            'previous_operations' => 'nullable|string',
            'current_medication' => 'nullable|string',
            'trauma_injuries' => 'nullable|string',
            
            // Medical History (Checkboxes/Booleans)
            'has_allergy' => 'nullable|boolean',
            'has_adverse_drug_reaction' => 'nullable|boolean',
            'has_abuse_negligence' => 'nullable|boolean',

            // Special Habits
            'habit_smoking' => 'nullable|boolean',
            'habit_alcohol' => 'nullable|boolean',
            'habit_other' => 'nullable|string|max:500',

            // Psychiatric History
            'psych_irrelevant' => 'nullable|boolean',
            'psych_follow_up' => 'nullable|boolean',
            'psych_medical_treatment' => 'nullable|boolean',
            'psych_other' => 'nullable|string|max:500',

            // Family History
            'family_diseases' => 'nullable|array',
            'family_diseases.*' => 'string|in:TB,Asthma,Cardiac,Consanguinity,Diabetes,Hypertension,Renal,Blood Dis.,Twins,Epilepsy,Cancer,Congenital anomalies,Psychiatric', // اختياري: للتأكد إن القيم المختارة مطابقة للـ UI
            'family_history_other' => 'nullable|string|max:1000',
        ];
    }
}
