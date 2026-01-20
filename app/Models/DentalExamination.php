<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DentalExamination extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_member_id',
        'location_type',
        'occupation',
        'dental_trauma_index',
        'permanent_teeth_status',
        'primary_teeth_status',
        'primary_dentition_step',
        'cpi_code',
        'dental_fluorosis',
        'extra_oral_code',
        'white_spot_lesions',
        'tmj_clicking',
        'tmj_tenderness',
        'tmj_reduced_mobility',
        'enamel_defects',
        'tooth_development_anomalies',
        'clefts',
        'oral_mucosa_condition',
        'oral_mucosa_location',
        'occlusion',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class);
    }
}
