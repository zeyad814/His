<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClinicalExamination extends Model
{
    protected $fillable = [
        "family_member_id",
        "visit_id",
        "visit_date",
        "age_stage",
        "clinical_assessment",
        "parental_concern",
        "health_education",
        "notes",
        "doctor_id",
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }
}
