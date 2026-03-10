<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OutpatientNursingAssessment extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'nurse_id',
        'weight',
        'height',
        'blood_pressure',
        'pulse',
        'respiratory_rate',
        'temperature',
        'spo2',
        'is_smoking',
        'is_alcoholic',
        'has_allergy',
        'allergy_details',
        'pain_score',
        'pain_location',
        'needs_detailed_fall_assessment',
        'final_fall_risk_level',
        'nursing_notes',
    ];

    protected $casts = [
        'is_smoking' => 'boolean',
        'is_alcoholic' => 'boolean',
        'has_allergy' => 'boolean',
        'needs_detailed_fall_assessment' => 'boolean',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'temperature' => 'decimal:1',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function fallAssessment()
    {
        return $this->hasOne(FallRiskAssessment::class, 'outpatient_nursing_assessment_id');
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class, 'nurse_id');
    }
}
