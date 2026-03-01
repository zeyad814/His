<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhysiotherapyAssessment extends Model
{
    //
    use HasFactory;

    protected $fillable = [
        "family_member_id",
        "doctor_id",
        "visit_id",
        "assessment_date",
        "case_type",
        "occupation",
        "referral_source",
        "medical_history_notes",
        "has_diabetes",
        "has_hypertension",
        "has_cardiac_disorder",
        "has_renal_disorder",
        "has_hepatic_disorder",
        "chief_complaint",
        "present_since",
        "onset",
        "course",
        "is_remittent",
        "pain_duration",
        "pain_status",
        "inv_x_ray",
        "inv_ct",
        "inv_mri",
        "inv_emg",
        "inv_lab",
        "investigation_details",
        "gait_assessment",
        "manual_muscle_test",
        "special_tests",
        "neurological_examination",
        // "body_chart_image",
        "diagnosis",
        "goal_relief_pain",
        "goal_reduce_swelling",
        "goal_improve_rom",
        "goal_improve_strength",
        "goal_improve_gait",
        "other_goals",
        "modality_us",
        "modality_ir",
        "modality_tens",
        "modality_faradic",
        "modality_laser",
        "manual_therapy_exercises",
        "follow_up_schedule",
    ];

    protected $casts = [
    'assessment_date' => 'date',
    ];

    public function familyMember()
    {
        return $this->belongsTo(FamilyMember::class, 'family_member_id');
    }

    public function visit()
    {
        return $this->belongsTo(Visit::class, 'visit_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id'); 
    }
}
