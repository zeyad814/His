<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'date',
        'visit_type',
        'complaint',
        'clinical_examination',
        'investigations',
        'diagnoses',
        'management_follow_up',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function hypertensionFollowUp()
    {
        return $this->hasOne(HypertensionFollowUp::class);
    }

    public function diabetesFollowUp()
    {
        return $this->hasOne(DiabetesFollowUp::class);
    }


    public function growthVisit()
    {
        return $this->hasOne(GrowthVisit::class);
    }

    public function clinicalExamination()
    {
        return $this->hasOne(ClinicalExamination::class, 'visit_id');
    }

    public function chronicDiseaseVisit()
    {
        return $this->hasOne(ChronicDiseaseVisit::class);
    }

    public function growthMeasurements()
    {
        return $this->hasMany(ChildGrowthMeasurement::class, 'visit_id');
    }

    public function childFollowup()
    {
        return $this->hasOne(ChildFollowup::class, 'visit_id');
    }

    public function childFollowupAboveFive()
    {
        return $this->hasOne(ChildFollowupAboveFive::class);
    }
}
