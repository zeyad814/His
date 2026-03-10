<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FallRiskAssessment extends Model
{
    //
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'outpatient_nursing_assessment_id',
        'scale_type',
        'm_history_falling',
        'm_secondary_diagnosis',
        'm_ambulatory_aid',
        'm_iv_therapy',
        'm_gait_transferring',
        'm_mental_status',
        'h_age',
        'h_gender',
        'h_diagnosis',
        'h_cognitive_impairment',
        'h_environmental_factors',
        'h_surgery_sedation',
        'h_medication_usage',
        'total_score',
        'risk_level',
    ];

    public function nursingAssessment()
    {
        return $this->belongsTo(OutpatientNursingAssessment::class, 'outpatient_nursing_assessment_id');
    }
}
