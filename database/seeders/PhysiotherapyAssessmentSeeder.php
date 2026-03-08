<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visit;
use App\Models\PhysiotherapyAssessment;
use Carbon\Carbon;

class PhysiotherapyAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // 1. إنشاء الزيارة (Visit) بناءً على الـ Migration الخاص بك
        $visit = Visit::create([
            'family_member_id'    => 1,
            'doctor_id'           => 1,
            'date'                => now()->format('Y-m-d'),
            'visit_type'          => 'زيارة دورية', // النوع المطلوب لتجاوز شرط الـ Controller
            'complaint'           => 'يعاني المريض من آلام شديدة في أسفل الظهر مع تنميل في القدم اليسرى.',
            'clinical_examination'=> 'وجود تيبس في العضلات القطنية واختبار SLR إيجابي عند 45 درجة.',
            'investigations'      => 'رنين مغناطيسي (MRI) يوضح انزلاق غضروفي بين الفقرة الرابعة والخامسة.',
            'diagnoses'           => 'انزلاق غضروفي قطني (Lumbar Disc Prolapse)',
            'management_follow_up'=> 'بدء جلسات علاج طبيعي مكثفة (3 جلسات أسبوعياً) مع المتابعة.',
        ]);

        // 2. إنشاء تقييم العلاج الطبيعي (Physiotherapy Assessment)
        PhysiotherapyAssessment::create([
            'family_member_id'      => 1,
            'doctor_id'             => 1,
            'visit_id'              => $visit->id,

            // البيانات الشخصية
            'assessment_date'       => now()->format('Y-m-d'),
            'case_type'             => 'Orthopedic',
            'occupation'            => 'محاسب (جلوس لفترات طويلة)',
            'referral_source'       => 'عيادة العظام الخارجية',

            // التاريخ المرضي
            'medical_history_notes' => 'تاريخ سابق لآلام الظهر منذ سنتين وتحسن بالراحة.',
            'has_diabetes'          => false,
            'has_hypertension'      => false,
            'has_cardiac_disorder'  => false,
            'has_renal_disorder'    => false,
            'has_hepatic_disorder'  => false,

            // التاريخ الحالي
            'chief_complaint'       => 'ألم حاد يزداد مع الجلوس والمشي لفترات.',
            'present_since'         => 'منذ شهر تقريباً',
            'onset'                 => 'gradual',
            'course'                => 'progressive',
            'is_remittent'          => false,
            'pain_duration'         => 'مستمر طوال اليوم',
            'pain_status'           => 'worsening',

            // الفحوصات
            'inv_x_ray'             => true,
            'inv_ct'                => false,
            'inv_mri'               => true,
            'inv_emg'               => false,
            'inv_lab'               => false,
            'investigation_details' => 'الرنين يظهر ضغط على جذور الأعصاب في الفقرات L4-L5.',

            // الفحص العام
            'gait_assessment'          => 'مشية غير متزنة لتجنب الألم (Antalgic Gait)',
            'manual_muscle_test'       => '4/5 في عضلات الساق اليسرى',
            'special_tests'            => 'Positive Slump test',
            'neurological_examination' => 'نقص طفيف في الإحساس بالجهة الخارجية للقدم',

            // التشخيص والأهداف
            'diagnosis'             => 'Lumbar Disc Prolapse L4-L5',
            'goal_relief_pain'      => true,
            'goal_reduce_swelling'  => false,
            'goal_improve_rom'      => true,
            'goal_improve_strength' => true,
            'goal_improve_gait'     => true,
            'other_goals'           => 'العودة للعمل وممارسة الحياة اليومية بدون ألم.',

            // البرنامج العلاجي
            'modality_us'              => true,
            'modality_ir'              => false,
            'modality_tens'            => true,
            'modality_faradic'         => false,
            'modality_laser'           => true,
            'manual_therapy_exercises' => 'Core stability exercises + McKenzie mobilization.',
            'follow_up_schedule'       => 'يوم السبت والاثنين والأربعاء من كل أسبوع.',
        ]);
    }
}