<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSurgeryUterusRequest extends FormRequest
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
            'family_planning_id'               => 'required|exists:family_plannings,id',
            'nurse_id'                         => 'required|exists:nurses,id',
            'diagnosis'                        => 'nullable|string',
            'patient_age'                      => 'nullable|integer|min:15|max:60',
            'procedure_type'                   => 'required|in:IUD_insertion,IUD_removal,Implant_insertion,Implant_removal',
            'patient_identity_verified'        => 'required|boolean',
            'informed_consent_signed'          => 'required|boolean',
            'site_side'                        => 'nullable|string',
            'procedure_site_marked'            => 'required|boolean',
            'equipment_sterilization_verified' => 'required|boolean',
            'supplies_availability_verified'   => 'required|boolean',
            'pregnancy_test_done'              => 'nullable|boolean',
            'hemoglobin_test_done'             => 'nullable|boolean',
            'final_team_verification'          => 'required|boolean',
            'procedure_date'                   => 'required|date',
            'procedure_time'                   => 'required',
            // فالييشن الأدوات (Array)
            'equipments'                       => 'required|array|min:1',
            'equipments.*.name'                => 'required|string',
            'equipments.*.status'              => 'required|string',
        ];
    }
}
