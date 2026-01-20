<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreProcedureChecklist extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_procedure_id',
        'doctor_id',
        'nurse_id',
        'labs_done',
        'medical_exam',
        'site_marked',
        'equipment_ready',
    ];

     public function medicalProcedure()
    {
        return $this->belongsTo(MedicalProcedure::class);
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
