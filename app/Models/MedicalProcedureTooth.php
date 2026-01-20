<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalProcedureTooth extends Model
{
    use HasFactory;

    protected $fillable = [
        'medical_procedure_id',
        'tooth_number',
    ];

    public function medicalProcedure()
    {
        return $this->belongsTo(MedicalProcedure::class);
    }
}
