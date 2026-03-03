<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PremaritalScreening extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'family_member_id',
        'doctor_id',
        'type',
        'consanguinity',
        'hereditary_diseases',
        'infectious_diseases',
        'chronic_diseases',
        'previous_surgeries',
        'blood_pressure',
        'pulse',
        'weight',
        'height',
        'bmi',
        'general_look',
        'blood_group_rh',
        'hemoglobin_level',
        'blood_sugar',
        'hbsag_result',
        'hiv_result',
        'medical_recommendation',
        'is_referred_to_specialist',
        'patient_informed',
        'examination_date',
    ];

    protected $casts = [
        'consanguinity' => 'boolean',
        'is_referred_to_specialist' => 'boolean',
        'patient_informed' => 'boolean',
        'examination_date' => 'datetime',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
        'bmi' => 'decimal:2',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }

    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    
    public function getNationalIdAttribute()
    {
        return $this->familyMember?->family?->national_id ?? 'N/A';
    }
}
