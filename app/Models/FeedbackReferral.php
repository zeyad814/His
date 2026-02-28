<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        "referral_id",
        "doctor_id",
        "arrival_at",
        "specialist_findings",
        "hospital_investigations",
        "final_diagnosis",
        "current_medications",
        "admission_ward",
        "surgery_type",
        "other_interventions",
        "recommendations",
        "revisit_date",
        "sick_leave_days",
        "follow_up_instructions",
    ];

    protected $casts = [
        'arrival_at' => 'datetime',
        'revisit_date' => 'date',
    ];

    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
