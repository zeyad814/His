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

    public function visit()
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

    public function surgeyUterus()
    {
        return $this->hasMany(SurgeryUterus::class);
    }

    public function familyInjections()
    {
        return $this->hasMany(FamilyInjection::class);
    }

    public function groom()
    {
        return $this->hasOne(Groom::class);
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
}
