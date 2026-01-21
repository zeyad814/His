<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Referral extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'referral_date',
        'transport_method',
        'target_facility',
        'reason_for_referral',
        'specialty',
        'type_of_referral',
        'relevant_history',
        'referral_serial_no',
        'exam_findings',
        'provisional_diag',
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
