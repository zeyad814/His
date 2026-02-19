<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyPlanningResource extends JsonResource
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
            
            // بيانات المريضة
            'family_member' => [
                'id'   => $this->family_member_id,
                'name' => $this->familyMember?->full_name,
            ],

            // بيانات الدكتور (من خلال علاقة الـ Morph)
            'doctor' => [
                'id'   => $this->doctor_id,
                'name' => $this->doctor?->user?->name, 
            ],
            
            'registration_date' => $this->registration_date,

            // التاريخ الإنجابي
            'reproductive_history' => [
                'pregnancies_count'    => $this->pregnancies_count,
                'abortions_count'      => $this->abortions_count,
                'alive_children_count' => $this->alive_children_count,
                'oldest_child_age'     => $this->oldest_child_age,
                'youngest_child_age'   => $this->youngest_child_age,
                'last_event_date'      => $this->last_delivery_or_abortion_date,
            ],

            // الحالة الصحية الحالية
            'health_status' => [
                'has_fever_or_discharge' => (bool)$this->has_fever_or_discharge,
                'is_breastfeeding'       => (bool)$this->is_breastfeeding,
            ],

            // سجل الوسائل
            'contraception' => [
                'is_using_now'    => (bool)$this->is_using_contraception_now,
                'current_method'  => $this->current_method_name,
                'used_before'     => (bool)$this->used_contraception_before,
                'previous_method' => $this->previous_method_name,
            ],

            // الفحص الطبي (الأسفل الورقة)
            'pelvic_examination' => [
                'vaginal_scaring_or_ulcer' => (bool)$this->vaginal_scaring_or_ulcer,
                'vaginal_discharge'        => (bool)$this->vaginal_discharge,
                'prolapse'                 => (bool)$this->prolapse,
                'uterus_position'          => $this->uterus_position,
                'uterus_tenderness'        => (bool)$this->uterus_tenderness,
                'uterus_size'              => $this->uterus_size,
                'cervix_status'            => $this->cervix_status,
            ],

            'conclusion' => $this->conclusion,
            
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
        ];
    }
}
