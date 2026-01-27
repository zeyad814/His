<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeneralExamination extends Model
{
    use HasFactory;

    protected $fillable = [
        'physical_examination_id',
        'blood_pressure',
        'pulse',
        'temperature',
        'respiratory_rate',
        'height',
        'weight',
        'bmi',
        'skin_complexion',
        'general_appearance',
        'upper_limb',
        'lower_limb',
        'pain_assessment',
        'disabilities',
        'deformities',
        'abdomen',
        'head_neck',
        'heart',
        'chest',
        'neurological',
        'eyes',
        'ent',
        'nutritional_assessment',
        'risk_factors',
        'conclusion',
        'lab_results',
    ];

    public function physicalExamination()
    {
        return $this->belongsTo(PhysicalExamination::class);
    }

    protected $casts = [
        'skin_complexion' => 'array',
        'head_neck' => 'array',
        'heart' => 'array',
        'chest' => 'array',
        'abdomen' => 'array',
        'neurological' => 'array',
        'upper_limb' => 'array',
        'lower_limb' => 'array',
        'disabilities' => 'array',
        'eyes' => 'array',
        'ent' => 'array',
        'risk_factors' => 'array',
        'lab_results' => 'array',
    ];
}
