<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalExamination extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'hospitalization',
        'previous_operations',
        'current_medication',
        'trauma_injuries',
        'has_allergy',
        'has_adverse_drug_reaction',
        'has_abuse_negligence',
        'habit_smoking',
        'habit_alcohol',
        'habit_other',
        'psych_irrelevant',
        'psych_follow_up',
        'psych_medical_treatment',
        'psych_other',
        'family_diseases',
        'family_history_other',
    ];

    protected $casts = [
        'family_diseases' => 'array',
        'has_allergy' => 'boolean',
        'has_adverse_drug_reaction' => 'boolean',
        'has_abuse_negligence' => 'boolean',
        'habit_smoking' => 'boolean',
        'habit_alcohol' => 'boolean',
        'psych_irrelevant' => 'boolean',
        'psych_follow_up' => 'boolean',
        'psych_medical_treatment' => 'boolean',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function generalExamination()
    {
        return $this->hasOne(GeneralExamination::class);
        //Currently modeled as one-to-one based on ERD, may evolve to one-to-many if follow-up exams are required
    }
}
