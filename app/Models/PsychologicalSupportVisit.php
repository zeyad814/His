<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PsychologicalSupportVisit extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'visit_date',
        'questionnaire_type',
        'visit_reason',
        'questionnaire_result',
        'initial_diagnosis',
        'treatment_plan',
        'referral_location',
        'doctor_id',
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
