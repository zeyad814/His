<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalProcedure extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'health_unit_id',
        'consent_given',
        'diagnosis',
        'procedure_date',
        'procedure_time',
        'procedure_type',
        'anesthesia_type',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function healthUnit()
    {
        return $this->belongsTo(HealthUnit::class);
    }

    public function medicalProcedureTeeth()
    {
        return $this->hasMany(MedicalProcedureTooth::class);
    }

    public function procedureTimeOut()
    {
        return $this->hasOne(ProcedureTimeout::class);
    }

    public function preProcedureChecklist()
    {
        return $this->hasOne(PreProcedureChecklist::class);
    }

    public function consent()
    {
        return $this->hasOne(ProcedureConsent::class);
    }
}
