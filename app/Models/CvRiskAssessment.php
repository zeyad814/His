<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CvRiskAssessment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "assessment_date",
        "hypertension",
        "dm",
        "obesity",
        "smoking",
        "family_history_cardiac",
        "bp",
        "height",
        "weight",
        "cholesterol_total",
        "ldl_level",
        "cv_risk_level",
        "management_plan",
        "referral_to",
        "follow_up_date",
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
