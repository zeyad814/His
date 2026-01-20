<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiabetesFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'date',
        'workup_every_visit',
        'health_education',
        'chief_complaint',
        'referrals',
        'risk_factors',
        'treatment_plan',
        'complications',
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
