<?php

namespace Database\Seeders;

use App\Models\FallRiskAssessment;
use App\Models\FamilyMember;
use App\Models\Nurse;
use App\Models\OutpatientNursingAssessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OutpatientNursingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // سحب أول سجل متاح للمريض والممرضة
        $memberId = FamilyMember::first()->id;
        $nurseId = Nurse::first()->id;

        // 1. إنشاء التقييم التمريضي العام (للبالغ)
        $assessment1 = OutpatientNursingAssessment::create([
            'family_member_id' => $memberId,
            'nurse_id' => $nurseId,
            'weight' => 75.5,
            'height' => 170,
            'blood_pressure' => '130/85',
            'pulse' => 80,
            'respiratory_rate' => 18,
            'temperature' => 37.2,
            'spo2' => 98,
            'is_smoking' => true,
            'has_allergy' => true,
            'allergy_details' => 'Penicillin',
            'pain_score' => 4,
            'pain_location' => 'Lower Back',
            'needs_detailed_fall_assessment' => true,
            'final_fall_risk_level' => 'High Risk',
        ]);

        // 2. ربط تقييم سقوط (مقياس مورس) بالتقييم الأول
        FallRiskAssessment::create([
            'outpatient_nursing_assessment_id' => $assessment1->id,
            'scale_type' => 'morse',
            'm_history_falling' => 25,
            'm_secondary_diagnosis' => 15,
            'm_ambulatory_aid' => 15,
            'm_iv_therapy' => 20,
            'm_gait_transferring' => 10,
            'm_mental_status' => 0,
            'total_score' => 85,
            'risk_level' => 'High Risk',
        ]);

        // 3. إنشاء تقييم تمريضي عام (لطفل)
        $assessment2 = OutpatientNursingAssessment::create([
            'family_member_id' => $memberId,
            'nurse_id' => $nurseId,
            'weight' => 15.0,
            'height' => 95,
            'blood_pressure' => '90/60',
            'pulse' => 110,
            'respiratory_rate' => 25,
            'temperature' => 36.8,
            'needs_detailed_fall_assessment' => true,
            'final_fall_risk_level' => 'Low Risk',
        ]);

        // 4. ربط تقييم سقوط (هامبتي دمبتي) بالتقييم الثاني
        FallRiskAssessment::create([
            'outpatient_nursing_assessment_id' => $assessment2->id,
            'scale_type' => 'humpty_dumpty',
            'h_age' => 4,
            'h_gender' => 2,
            'h_diagnosis' => 1, 
            'h_cognitive_impairment' => 1,
            'h_environmental_factors' => 1,
            'h_surgery_sedation' => 1,
            'h_medication_usage' => 1,
            'total_score' => 11,
            'risk_level' => 'Low Risk',
        ]);
    }
}
