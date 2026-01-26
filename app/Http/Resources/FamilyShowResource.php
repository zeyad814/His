<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FamilyShowResource extends JsonResource
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
            'family_code' => $this->family_code,
            'head_name' => $this->head_name,
            'national_id' => $this->national_id,
            'location' => [
                'governorate' => $this->governorate,
                'health_department' => $this->health_department,
                'health_unit' => $this->health_unit,
                'address' => $this->address,
            ],
            'contact_phones' => [
                'mobile' => $this->mobile_phone,
                'work' => $this->work_phone,
                'nearest' => $this->nearest_phone,
            ],
            'members' => $this->members->map(function($member) {
                return [
                    'name' => $member->full_name,
                    'gender' => $member->is_male ? 'ذكر' : 'أنثى',
                    'birth_date' => $member->birth_date,
                    'relationship' => $member->relationship_to_head,
                    'insurance_type' => $member->insurance_type,
                    "notes" => $member->notes,
                    
                    'medical_history' => $member->medicalHistories->map(function($history) {
                        return [
                            'disease_type' => $history->disease_type,
                            'discovery_date' => $history->discovery_date,
                            'type_of_illness' => $history->type_of_illness,
                            'note' => $history->note,
                        ];
                    }),
                ];
            }),
            // أطباء العائلة
            'family_doctor' => [
                'name' => $this->familyDoctor?->user?->name,
                'assign_date' => $this->family_doctor_assign_date,
            ],
            'dentist_doctor' => [
                'name' => $this->dentistDoctor?->user?->name,
                'assign_date' => $this->dentist_assign_date,
            ],
            'death_records' => $this->deathRecords->map(function($record) {
                return [
                    'member_name' => $record->familyMember?->full_name,
                    'age_at_death' => $record->age_at_death,
                    'death_date' => $record->death_date,
                    'cause_of_death'=> $record->cause_of_death,
                    'death_code' => $record->death_code,
                ];
            }), 
            // البحث الاجتماعي وحالة المسكن
            'housing_info' => $this->housingInfo ? [
                'rooms_count' => $this->housingInfo->rooms_count,
                'sleeping_rooms_specified' => $this->housingInfo->sleeping_rooms_specified,
                'ventilation' => $this->housingInfo->ventilation,
                'water_source' => $this->housingInfo->water_source,
                'sanitation_type' => $this->housingInfo->sanitation_type,
                'lighting_type' => $this->housingInfo->lighting_type,
                'has_animals' => $this->housingInfo->has_animals,
                'barn_location' => $this->housingInfo->barn_location,
            ] : null,
            'social_research' => $this->socialResearch ? [
                'income_type' => $this->socialResearch->income_type,
                'avg_income' => $this->socialResearch->avg_income,
                'has_chronic_diseases' => (int) $this->socialResearch->has_chronic_diseases,
                'has_disability' => (int) $this->socialResearch->has_disability,
                'receives_pension' => (int) $this->socialResearch->receives_pension,
                'eligible_for_free_service' => (int) $this->socialResearch->eligible_for_free_service,
                'supporter_name_on_death' => $this->socialResearch->supporter_name_on_death, 
            ] : null,
        ];
    }
}
