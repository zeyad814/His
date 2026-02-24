<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SurgeryUterusResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            
            // تقسيم بيانات الطبيب والممرضة والإدارة
            'doctor' => [
                'id'   => $this->doctor_id,
                'name' => $this->doctor->user->name ?? 'N/A', 
            ],
            'nurse' => [
                'id'   => $this->nurse_id,
                'name' => $this->nurse?->name,  
            ],
            'family_planning' => [
                'id'   => $this->family_planning_id,
                'patient_name' => $this->familyPlanning?->familyMember?->full_name,
            ],

            // البيانات الطبية الأساسية
            'medical_info' => [
                'diagnosis'      => $this->diagnosis,
                'patient_age'    => $this->patient_age,
                'procedure_type' => $this->procedure_type,
            ],

            // 1. التحقق قبل الإجراء (Pre-procedure Check)
            'pre_procedure' => [
                'patient_identity_verified'  => (bool) $this->patient_identity_verified,
                'informed_consent_signed'    => (bool) $this->informed_consent_signed,
                'site_side'                  => $this->site_side,
                'procedure_site_marked'      => (bool) $this->procedure_site_marked,
            ],

            // 2. التحقق من التجهيزات
            'equipment_check' => [
                'equipment_sterilization_verified' => (bool) $this->equipment_sterilization_verified,
                'supplies_availability_verified'   => (bool) $this->supplies_availability_verified,
            ],

            // 3. الفحوصات
            'tests' => [
                'pregnancy_test_done'  => (bool) $this->pregnancy_test_done,
                'hemoglobin_test_done' => (bool) $this->hemoglobin_test_done,
            ],

            // 4. Time Out
            'final_verification' => (bool) $this->final_team_verification,

            // التاريخ والوقت
            'schedule' => [
                'date' => $this->procedure_date,
                'time' => $this->procedure_time,
            ],

            // الأدوات المرتبطة (الجدول التاني)
            'equipments' => $this->equipments->map(function($equipment) {
                return [
                    'id'     => $equipment->id,
                    'name'   => $equipment->name,
                    'status' => $equipment->status,
                ];
            }),

            'created_at' => $this->created_at?->toDateTimeString(),
        ];
    }
}
