<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\HypertensionFollowUp;
use App\Models\FamilyMember;
use App\Models\Doctor;
use App\Models\Visit;

class HypertensionFollowUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. جلب أول 5 أفراد وأول دكتور للتجربة
        $members = FamilyMember::limit(5)->get();
        $doctor = Doctor::first();

        // التأكد من وجود بيانات أساسية قبل البدء
        if (!$doctor || $members->isEmpty()) {
            $this->command->error('Please seed Doctors and FamilyMembers first!');
            return;
        }

        foreach ($members as $member) {
            // 2. إنشاء الزيارة أولاً (نموذج التردد) لربط المتابعة بها
            $visit = Visit::create([
                'family_member_id'     => $member->id,
                'doctor_id'            => $doctor->id,
                'date'                 => now()->format('Y-m-d'),
                'visit_type'           => 'أمراض مزمنة', // النوع المطلوب في الـ Validation
                'complaint'            => 'Occasional headaches',
                'clinical_examination' => 'Normal clinical signs, BP elevated.',
                'diagnoses'            => 'Hypertension Follow-up',
                'management_follow_up' => 'See hypertension details',
            ]);

            // 3. إنشاء سجل متابعة الضغط
            HypertensionFollowUp::create([
                'visit_id'         => $visit->id, // الربط الأساسي
                'family_member_id' => $member->id,
                'doctor_id'        => $doctor->id,
                'date'             => now()->format('Y-m-d'),

                // الخطوة 1: الشكوى والضغط (تم فك الـ BP لأعمدة منفصلة)
                'chief_complaint'  => 'Occasional headaches and blurred vision.',
                'bp_systolic'      => rand(130, 160),
                'bp_diastolic'     => rand(85, 100),

                // الخطوة 2: المخاطر والمضاعفات (تخزن كـ JSON)
                'risk_factors' => [
                    'smoking'             => (bool)rand(0, 1),
                    'physical_inactivity' => true,
                    'obese'               => false,
                    'family_history'      => true,
                    'dyslipidemia'        => (bool)rand(0, 1),
                ],
                'complications_and_target_organ_affection' => [
                    'lvh_hf'      => false,
                    'angina_mi'   => false,
                    'stroke_tia'  => false,
                    'ckd'         => (bool)rand(0, 1),
                    'retinopathy' => false,
                ],

                // الخطوة 3: الفحوصات (تخزن كـ JSON)
                'workup_6_month' => [
                    'urine_analysis'  => 'Normal trace of protein',
                    'creatinine_egfr' => '1.1 mg/dL',
                ],
                'workup_annual' => [
                    'total_cholesterol' => '210 mg/dL',
                    'cbc'               => 'Normal',
                    'fasting_sugar'     => '105 mg/dL',
                    'k_na'              => 'K: 4.0, Na: 138',
                    'ecg'               => 'Normal Sinus Rhythm',
                    'tg'                => '160 mg/dL',
                    'hdl'               => '40 mg/dL',
                    'ldl'               => '130 mg/dL',
                ],

                // الخطوة 4: التثقيف والعلاج
                'health_education' => [
                    'diet_weight_loss'  => true,
                    'physical_activity' => true,
                    'low_salt'          => true,
                    'quitting_smoking'  => false,
                ],
                'treatment_plan' => 'Start Enalapril 10mg once daily. Re-evaluate in 2 weeks.',
            ]);
        }

        $this->command->info('Hypertension records linked to Chronic Disease visits created successfully!');
    }
}
