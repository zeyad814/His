<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HypertensionFollowUp;
use App\Models\FamilyMember;
use App\Models\Doctor;

class HypertensionFollowUpSeeder extends Seeder
{
    public function run(): void
    {
        // جلب أول 5 أفراد وأول دكتور للتجربة
        $members = FamilyMember::limit(5)->get();
        $doctor = Doctor::first();

        if (!$doctor || $members->isEmpty()) {
            $this->command->info('Please seed Doctors and FamilyMembers first!');
            return;
        }

        foreach ($members as $member) {
            HypertensionFollowUp::create([
                'family_member_id' => $member->id,
                'doctor_id' => $doctor->id,
                'date' => now()->format('Y-m-d'),

                // الخطوة 1: الضغط والشكوى
                'chief_complaint' => 'Occasional headaches and blurred vision.',
                'bp' => [
                    'systolic' => rand(130, 160),
                    'diastolic' => rand(85, 100),
                ],

                // الخطوة 2: المخاطر والمضاعفات
                'risk_factors' => [
                    'smoking' => (bool)rand(0, 1),
                    'physical_inactivity' => true,
                    'obese' => false,
                    'family_history' => true,
                    'dyslipidemia' => (bool)rand(0, 1),
                ],
                'complications_and_target_organ_affection' => [
                    'lvh_hf' => false,
                    'angina_mi' => false,
                    'stroke_tia' => false,
                    'ckd' => (bool)rand(0, 1),
                    'retinopathy' => false,
                ],

                // الخطوة 3: الفحوصات
                'workup_6_month' => [
                    'urine_analysis' => 'Normal trace of protein',
                    'creatinine_egfr' => '1.1 mg/dL',
                ],
                'workup_annual' => [
                    'total_cholesterol' => '210',
                    'cbc' => 'Normal',
                    'fasting_sugar' => '105',
                    'k_na' => 'K: 4.0, Na: 138',
                    'ecg' => 'Normal Sinus Rhythm',
                    'tg' => '160',
                    'hdl' => '40',
                    'ldl' => '130',
                ],

                // الخطوة 4: التثقيف والعلاج
                'health_education' => [
                    'diet_weight_loss' => true,
                    'physical_activity' => true,
                    'low_salt' => true,
                    'quitting_smoking' => false,
                ],
                'treatment_plan' => 'Start Enalapril 10mg once daily. Re-evaluate in 2 weeks.',
            ]);
        }
    }
}
