<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurgeryUterus extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'nurse_id',
        'correct_procedure_verified',
        'procedure_type',
        'site_side',
        'correct_site_verified',
        'correct_patient_verified',
        'site_marked',
        'procedure_date',
        'procedure_time',
        'hemoglobin_test_done',
        'pregnancy_test_done',
        'labs_completed',
        'diagnosis',
        'patient_age',
        'medical_exam_done',
        'medical_assessment_done',
        'site_cleaned',
        'site_identified',
    ];


    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }
}
