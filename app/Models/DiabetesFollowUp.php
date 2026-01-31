<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiabetesFollowUp extends Model
{
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "visit_id",
        "date",
        "chief_complaint",
        // "bmi",
        "risk_factors",
        "complications",
        "workup_every_visit",
        "workup_6_month",
        "workup_annual",
        "health_education",
        "referrals",
        "treatment_plan",
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'date' => 'date',
        'risk_factors' => 'array',
        'complications' => 'array',
        'workup_every_visit' => 'array',
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
