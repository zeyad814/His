<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BirthScreening extends Model
{
    protected $fillable = [
        "family_member_id",
        "has_danger_signs",
        "danger_signs_details",
        "delivery_type",
        "delivery_place",
        "delivered_by",
        "incubator_entry",
        "incubator_reason_duration",
        "breastfeeding_start",
        "has_jaundice",
        "jaundice_date",
        "jaundice_action_treatment",
        "first_sample_date",
        "first_sample_result",
        "repeated_sample_date",
        "repeated_sample_result",
        "venous_sample_date",
        "final_screening_result",
        "final_diagnosis",
        "oae_test_result",
        "vitamin_a_dose",
        "sensory_defects",
        "speech_difficulties",
        "growth_retardation",
        "autism",
        "genetic_diseases",
        "allergies",
        "other_special_cases",
        "special_cases_medications",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function growthVisits()
    {
        return $this->hasMany(GrowthVisit::class, 'birth_screening_id');
    }
}
