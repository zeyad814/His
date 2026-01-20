<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureConsent extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_procedure_id',
        'diagnosis_details',
        'benefits',
        'complications',
        'alternatives',
    ];

     public function medicalProcedure()
    {
        return $this->belongsTo(MedicalProcedure::class);
    }
}
