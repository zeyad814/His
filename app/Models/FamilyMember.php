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
}
