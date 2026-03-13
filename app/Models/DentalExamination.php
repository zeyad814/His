<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalExamination extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "occupation",
        "location_type",
        "extra_oral_exam",
        "tmj_symptom",
        "tmj_signs",
        "tmj_clicking",
        "tmj_tenderness",
        "tmj_reduced_mobility",
        "mucosa_condition",
        "mucosa_location",
        "mucosa_other",
        "cpi_sections",
        "fluorosis_index",
        "trauma_index",
        "white_spot_lesions",
        "enamel_defects",
        "developmental_anomalies",
        "clefts",
        "occlusion_class",
        "primary_mesial_step",
    ];

    protected $casts = [
        'cpi_sections' => 'array',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
    
    public function doctor()
    {
        return $this->belongsTo(Doctor::class);
    }

    public function toothStatuses()
    {
        return $this->hasMany(ToothStatus::class);
    }
}
