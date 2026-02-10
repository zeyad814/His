<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BirthScreening;
use App\Models\GrowthVisit;
use Illuminate\Support\Facades\DB;

class BirthScreeningSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1. إنشاء بيانات فحص الولادة مع دمج بيانات الحالات الخاصة (Special Cases)
            // استخدمنا updateOrCreate لضمان عدم التكرار إذا تم تشغيل الـ seeder مرتين
            $screening = BirthScreening::updateOrCreate(
                ['family_member_id' => 1],
                [
                    // بيانات الـ Birth Screening الأساسية
                    'has_danger_signs' => true,
                    'danger_signs_details' => "Presence of respiratory distress during the first few hours.",
                    'delivery_type' => "Natural",
                    'delivery_place' => "General Hospital - Ward 3",
                    'delivered_by' => "Dr. Sarah Ahmed",
                    'incubator_entry' => false,
                    'incubator_reason_duration' => null,
                    'breastfeeding_start' => "Within the first hour",
                    'has_jaundice' => true,
                    'jaundice_date' => "2026-02-05",
                    'jaundice_action_treatment' => "Observed and treated with phototherapy",
                    'first_sample_date' => "2026-02-06",
                    'first_sample_result' => "Normal",
                    'repeated_sample_date' => null,
                    'repeated_sample_result' => null,
                    'venous_sample_date' => "2026-02-07",
                    'final_screening_result' => "Negative",
                    'final_diagnosis' => "Healthy condition, follow-up required",
                    'oae_test_result' => "Pass",
                    'vitamin_a_dose' => "9_months",
                    
                    // دمج بيانات الـ Special Cases (لأنها تخزن في نفس الجدول حسب الكود الخاص بك)
                    'sensory_defects' => true,
                    'autism' => false,
                    'allergies' => true,
                    'other_special_cases' => "Lactose intolerance",
                ]
            );

            // 2. إنشاء بيانات زيارة النمو (Growth Visit)
            // تأكد من وجود visit_id = 5 في جدول الزيارات أولاً أو استبدله بـ ID صالح
            GrowthVisit::updateOrCreate(
                ['visit_id' => 5],
                [
                    'family_member_id' => 1,
                    'birth_screening_id' => $screening->id,
                    'visit_date' => "2026-02-03",
                    'age_stage' => "2",
                    'weight_kg' => 5.80,
                    'height_cm' => 59.5,
                    'head_circumference_cm' => 39.0,
                    'use_pacifier' => false,
                    'exclusive_breastfeeding' => true,
                    'supplementary_feeding' => true,
                    'bottle_feeding' => false,
                    'cup_spoon_feeding' => false,
                    'natural_breastfeeding' => true,
                    'other_foods' => "Testing: All data sent",
                    'hemoglobin_level' => 11.2,
                    'mandatory_vaccinations' => true,
                    'other_vaccinations' => "BCG, HepB",
                    'vaccination_date' => "2026-02-03"
                ]
            );
        });
    }
}