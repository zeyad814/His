<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_id',
        'health_unit_id',
        'national_id',
        'name',
        'phone',
        'specialization',
        'license_number',
        'start_date',
    ];

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function healthUnit()
    {
        return $this->belongsTo(HealthUnit::class);
    }

    public function significantData()
    {
        return $this->hasMany(SignificantData::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function hypertensionFollowUps()
    {
        return $this->hasMany(HypertensionFollowUp::class);
    }

    public function diabetesFollowUps()
    {
        return $this->hasMany(DiabetesFollowUp::class);
    }

    public function chronicDiseases()
    {
        return $this->hasMany(ChronicDisease::class);
    }

    public function pregnancyVisits()
    {
        return $this->hasMany(PregnancyVisit::class);
    }

    public function surgeyUterus()
    {
        return $this->hasMany(SurgeryUterus::class);
    }

    public function familyInjections()
    {
        return $this->hasMany(FamilyInjection::class);
    }

    public function consents()
    {
        return $this->hasMany(Consent::class);
    }

    public function geriatricAssessments()
    {
        return $this->hasMany(GeriatricAssessmentMaster::class);
    }

    public function medicalProcedures()
    {
        return $this->hasMany(MedicalProcedure::class);
    }

    public function procedureTimeOuts()
    {
        return $this->hasMany(ProcedureTimeout::class);
    }

    public function preProcedureChecklists()
    {
        return $this->hasMany(PreProcedureChecklist::class);
    }

    public function referrals()
    {
        return $this->hasMany(Referral::class);
    }

    public function feedbackReferrals()
    {
        return $this->hasMany(FeedbackReferral::class);
    }

    public function drugCompatibilities()
    {
        return $this->hasMany(DrugCompatibility::class);
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

    public function radiologyReports()
    {
        return $this->hasMany(RadiologyReport::class);
    }
}
