<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "referral_number",
        "referred_to_entity",
        "specialty",
        "transport_method",
        "reason_for_referral",
        "urgency_type",
        "bp",
        "pulse",
        "temp",
        "rr",
        "relevant_history",
        "exam_findings",
        "relevant_investigations",
        "provisional_diagnosis",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function feedbackReferral()
{
    return $this->hasOne(FeedbackReferral::class);
}

}
