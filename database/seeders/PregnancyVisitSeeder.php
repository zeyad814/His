<?php

namespace Database\Seeders;

use App\Models\PregnancyVisit;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PregnancyVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PregnancyVisit::create([
            'pregnancy_id' => 1,
            'doctor_id' => 1,
            'visit_id' => 12,
            'visit_date' => '2024-02-01',
            'next_visit' => '2024-03-01',
            'weight' => 75.0,
            'blood_pressure' => '120/80',
            'general_exam' => 'No edema, normal thyroid', // فحص عام (لا يوجد تورم)

            // التقييم التوليدي (الـ 4 خانات اللي فصلناهم)
            'fundal_height' => '24 cm',
            'fetal_lie' => 'Cephalic', // وضع الجنين (رأسي)
            'fetal_heart_rate' => '145 bpm',
            'fetal_movement' => 'Normal',
            'ultrasound' => 'Single live fetus, normal anatomy',

            // التحاليل (Labs)
            'urine_analysis' => 'No protein, No sugar',
            'hemoglobin' => 12.5,
            'blood_glucose' => 95.0,

            // التثقيف والأسنان
            'dental' => 'Checked - Healthy',
            'vitamins' => 'Iron & Calcium started',
            'health_education' => 'Nutrition and signs of danger explained',
            'complications' => 'None',
            
        ]);
    }
}
