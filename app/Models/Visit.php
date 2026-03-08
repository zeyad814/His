<?php

namespace App\Models;

use App\Models\ChildGrowthMeasurement;
use App\Models\ChronicDiseaseVisit;
use App\Models\ClinicalExamination;
use App\Models\DiabetesFollowUp;
use App\Models\Doctor;
use App\Models\FamilyMember;
use App\Models\GrowthVisit;
use App\Models\HypertensionFollowUp;
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

    // public function childFollowup()
    // {
    //     return $this->hasOne(ChildFollowup::class, 'visit_id');
    // }

    public function childFollowupAboveFive()
    {
        return $this->hasOne(ChildAboveFiveClinical::class);
    }

    public function obesityRecord()
    {
        return $this->hasOne(ObesityRecord::class, 'visit_id');
    }

    public function physioAssessment()
    {
        return $this->hasOne(PhysiotherapyAssessment::class, 'visit_id');
    }

    // كل النتائج الحرجة التي ظهرت خلال هذه الزيارة
    public function criticalResults()
    {
        return $this->hasMany(CriticalResult::class, 'visit_id');
    }
}
