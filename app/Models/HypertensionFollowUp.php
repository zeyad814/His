<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HypertensionFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'date',
        'health_education',
        'treatment_plan',
        'chief_complaint',
        'bp',
        'risk_factors',
        'target_organ_affection',
        'workup_6_month',
        'workup_annual',

    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
