<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VitalSign extends Model
{
    use HasFactory;

    protected $fillable = [
        'emergency_form_id',
        'pulse',
        'bp_systolic',
        'temperature',
        'attribute',
        'respiratory_rate',
        'consciousness_level',
        'oxygen_saturation',
        'blood_sugar',
    ];

    public function emergencyForm()
    {
        return $this->belongsTo(EmergencyForm::class);
    }
}
