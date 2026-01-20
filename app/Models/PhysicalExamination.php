<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysicalExamination extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'family_history',
        'hospitalization',
        'lab_tests_results',
        'special_habits',
        'previous_operations',
        'current_medication',
        'trauma_injuries',
        'allergy',
        'adverse_drug_reaction',
        'abuse_negligence',
        'psychiatric_history',
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
