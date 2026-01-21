<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackReferral extends Model
{
    use HasFactory;

    protected $fillable = [
        'referral_id',
        'doctor_id',
        'other_interventions',
        'revisit_date',
        'arrival_date_time',
        'sick_leave',
        'exam_findings',
        'follow_up_instructions',
        'investigations',
        'final_diagnoses',
        'current_medications',
        'admission_ward',
        'surgery_type',
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
