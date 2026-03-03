<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyMember extends Model
{
    use HasFactory;

    protected $fillable = [
        'full_name',
        'is_male',
        'birth_date',
        'relationship_to_head',
        'insurance_type',
        'notes',
        'family_id',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function medicalHistories()
    {
        return $this->hasMany(MedicalHistory::class);
    }

    public function deathRecord()
    {
        return $this->hasOne(DeathRecord::class);
    }

    public function physicalExamination()
    {
        return $this->hasOne(PhysicalExamination::class);
    }

    public function significantData()
    {
        return $this->hasMany(SignificantData::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function dentalExamination()
    {
        return $this->hasOne(DentalExamination::class);
    }

    public function hypertensionFollowUp()
    {
        return $this->hasMany(HypertensionFollowUp::class);
    }

    public function diabetesFollowUp()
    {
        return $this->hasMany(DiabetesFollowUp::class);
    }

    public function chronicDiseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function pregnancies()
    {
        return $this->hasMany(Pregnancy::class);
    }

    // public function surgeyUterus()
    // {
    //     return $this->hasMany(SurgeryUterus::class);
    // }

    public function familyInjections()
    {
        return $this->hasMany(FamilyInjection::class);
    }

    public function premaritalScreenings()
    {
        return $this->hasMany(PremaritalScreening::class);
    }

    public function geriatricAssessments()
    {
        return $this->hasMany(GeriatricAssessmentMaster::class);
    }

    public function medicalProcedures()
    {
        return $this->hasMany(MedicalProcedure::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function pharmacies()
    {
        return $this->hasMany(Pharmacy::class);
    }

    public function labRequests()
    {
        return $this->hasMany(LabRequest::class);
    }

    public function medicalConsents()
    {
        return $this->hasMany(MedicalConsent::class);
    }

    public function radiologicalRequests()
    {
        return $this->hasMany(RadiologicalRequest::class);
    }

    public function emergencyForms()
    {
        return $this->hasMany(EmergencyForm::class);
    }

    public function clinicalExaminations()
    {
        return $this->hasMany(ClinicalExamination::class, 'family_member_id');
    }

    public function growthMeasurements()
    {
        return $this->hasMany(ChildGrowthMeasurement::class, 'family_member_id');
    }

    // public function childFollowups()
    // {
    //     return $this->hasMany(ChildFollowup::class, 'family_member_id');
    // }

    public function childFollowupsAboveFive()
    {
        return $this->hasMany(ChildAboveFiveClinical::class);
    }

    public function obesityRecords()
    {
        return $this->hasMany(ObesityRecord::class, 'family_member_id');
    }

    public function psychologicalSupportVisits()
    {
        return $this->hasMany(PsychologicalSupportVisit::class, 'family_member_id');
    }

    public function familyPlannings()
    {
        return $this->hasMany(FamilyPlanning::class, 'family_member_id');
    }

    public function cvRiskAssessments()
    {
        return $this->hasMany(CvRiskAssessment::class, 'family_member_id');
    }

    public function verbalOrders()
    {
        return $this->hasMany(VerbalOrder::class);
    }

    public function physiotherapyAssessments()
    {
        return $this->hasMany(PhysiotherapyAssessment::class, 'family_member_id');
    }
}
