<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSurgeryUterusRequest extends FormRequest
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
            'family_planning_id'               => 'sometimes|required|exists:family_plannings,id',
        'nurse_id'                         => 'sometimes|required|exists:nurses,id',
        'diagnosis'                        => 'nullable|string',
        'patient_age'                      => 'sometimes|nullable|integer|min:15|max:60',
        'procedure_type'                   => 'sometimes|required|in:IUD_insertion,IUD_removal,Implant_insertion,Implant_removal',
        'patient_identity_verified'        => 'sometimes|required|boolean',
        'informed_consent_signed'          => 'sometimes|required|boolean',
        'site_side'                        => 'nullable|string',
        'procedure_site_marked'            => 'sometimes|required|boolean',
        'equipment_sterilization_verified' => 'sometimes|required|boolean',
        'supplies_availability_verified'   => 'sometimes|required|boolean',
        'pregnancy_test_done'              => 'nullable|boolean',
        'hemoglobin_test_done'             => 'nullable|boolean',
        'final_team_verification'          => 'sometimes|required|boolean',
        'procedure_date'                   => 'sometimes|required|date',
        'procedure_time'                   => 'sometimes|required',
        // فالييشن الأدوات
        'equipments'                       => 'sometimes|required|array|min:1',
        'equipments.*.name'                => 'required_with:equipments|string',
        'equipments.*.status'              => 'required_with:equipments|string',
    
        ];
    }
}
