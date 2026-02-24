<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SurgeryUterus extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_planning_id',
        'doctor_id',
        'nurse_id',
        'diagnosis',
        'patient_age',
        'procedure_type',
        'patient_identity_verified',
        'informed_consent_signed',
        'site_side',
        'procedure_site_marked',
        'equipment_sterilization_verified',
        'supplies_availability_verified',
        'pregnancy_test_done',
        'hemoglobin_test_done',
        'final_team_verification',
        'procedure_date',
        'procedure_time',
    ];

    protected function casts(): array
    {
        return [
            'patient_identity_verified' => 'boolean',
            'informed_consent_signed' => 'boolean',
            'procedure_site_marked' => 'boolean',
            'equipment_sterilization_verified' => 'boolean',
            'supplies_availability_verified' => 'boolean',
            'pregnancy_test_done' => 'boolean',
            'hemoglobin_test_done' => 'boolean',
            'final_team_verification' => 'boolean',
            'procedure_date' => 'date',
            'procedure_time' => 'datetime:H:i',
        ];
    }


    // public function familyMember()
    // {
    //     return $this->belongsTo(FamilyMember::class);
    // }

    public function familyPlanning()
    {
        return $this->belongsTo(FamilyPlanning::class, 'family_planning_id');
    }

    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function nurse()
    {
        return $this->belongsTo(Nurse::class);
    }

    public function equipments()
    {
        return $this->hasMany(ProcedureEquipment::class);
    }
}
