<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureTimeOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_procedure_id',
        'doctor_id',
        'nurse_id',
        'patient_confirmed',
        'procedure_confirmed',
        'site_confirmed',
        'antibiotic_given',
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
