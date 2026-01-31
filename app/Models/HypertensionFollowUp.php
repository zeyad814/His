<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypertensionFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "date",
        "chief_complaint",
        "bp_systolic",
        "bp_diastolic",
        "risk_factors",
        "complications_and_target_organ_affection",
        "workup_6_month",
        "workup_annual",
        "health_education",
        "treatment_plan",
        "visit_id",
    ];

    protected $casts = [
        'date' => 'date',
        // 'bp' => 'array',
        'risk_factors' => 'array',
        'complications_and_target_organ_affection' => 'array',
        'workup_6_month' => 'array',
        'workup_annual' => 'array',
        'health_education' => 'array',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }
}
