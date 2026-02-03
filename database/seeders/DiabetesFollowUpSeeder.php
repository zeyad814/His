<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DiabetesFollowUp;
use App\Models\FamilyMember;
use App\Models\Visit;
use App\Models\Doctor;

class DiabetesFollowUpSeeder extends Seeder
{
    public function run(): void
    {
        // 1. الحصول على بيانات أساسية للربط (تأكد من وجودها في الداتابيز أو أنشئها)
        $doctor = Doctor::first() ?? Doctor::factory()->create();
        $member = FamilyMember::first() ?? FamilyMember::factory()->create();

        // 2. إنشاء زيارة من نوع "أمراض مزمنة" لأن الكود عندك يشترط هذا النوع
        $visit = Visit::create([
            'family_member_id' => $member->id,
            'doctor_id' => $doctor->id,
            'visit_type' => 'أمراض مزمنة',
            // 'status' => 'completed',
            'date' => now(),
        ]);

        // 3. تخزين الداتا (محاكاة للـ 4 خطوات في سجل واحد)
        DiabetesFollowUp::create([
            // بيانات Step 1 (الأساسية)
            'visit_id' => $visit->id,
            'family_member_id' => $member->id,
            'doctor_id' => $doctor->id,
            'date' => now()->format('Y-m-d'),
            'chief_complaint' => 'يعاني من عطش شديد وزيادة في عدد مرات التبول.',

            // بيانات Step 2 (Risk Factors & Complications)
            // بما أنك تستخدم مصفوفات في الـ Request، تأكد أن الموديل يستخدم $casts لـ array
            'risk_factors' => [
                'smoking' => true,
                'physical_inactivity' => true,
                'bmi' => false,
                'dyslipidemia' => true,
                'family_history' => true,
            ],
            'complications' => [
                'ckd' => false,
                'neuropathy' => true,
                'retinopathy' => false,
                'diabetic_foot' => false,
                'dka_hypoglycemia' => true,
            ],

            // بيانات Step 3 (Lab Workup)
            'workup_every_visit' => [
                'fbs' => '140 mg/dL',
                'urine_analysis' => 'Normal',
            ],
            'workup_6_month' => [
                'hba1c' => '7.5%',
                'creatinine_egfr' => '90 mL/min',
            ],
            'workup_annual' => [
                'total_cholesterol' => '200',
                'fundus_examination' => 'Normal',
                'foot_examination' => 'No ulcers',
                'ecg' => 'Normal sinus rhythm',
                'urinary_micr' => 'Negative',
                'ldl' => '110',
                'hdl' => '45',
                'tg' => '150',
            ],

            // بيانات Step 4 (Education & Treatment)
            'health_education' => [
                'diet_weight_loss' => true,
                'physical_activity' => true,
                'smbg_hypoglycemia' => true,
                'quitting_smoking' => false,
            ],
            'referrals' => 'تحويل إلى أخصائي تغذية وعيون.',
            'treatment_plan' => 'Metformin 500mg once daily after meal.',
        ]);
    }
}
