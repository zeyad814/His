<?php

namespace Database\Seeders;

use App\Models\DentalExamination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DentalExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::transaction(function ()
        {
            // إنشاء أول فحص تجريبي
            $exam1 = DentalExamination::create([
                'family_member_id' => 1, // تأكد إن المريض ده موجود في قاعدة البيانات
                'doctor_id' => 1, // تأكد إن الدكتور ده موجود
                'occupation' => 'Software Engineer',
                'location_type' => 1,
                'extra_oral_exam' => 0,
                'tmj_symptom' => 0,
                'tmj_signs' => 0,
                'tmj_clicking' => false,
                'tmj_tenderness' => false,
                'tmj_reduced_mobility' => false,
                'mucosa_condition' => 0,
                'mucosa_location' => 0,
                'mucosa_other' => 'Healthy mucosa',
                'cpi_sections' => ["0", "1", "0", "0", "1", "0"],
                'fluorosis_index' => 0,
                'trauma_index' => 0,
                'white_spot_lesions' => 'None',
                'enamel_defects' => 'None',
                'developmental_anomalies' => 'None',
                'clefts' => 'None',
                'occlusion_class' => 1,
                'primary_mesial_step' => 1,
            ]);

            // إضافة حالات الأسنان للفحص الأول
            $exam1->toothStatuses()->createMany([
                ['tooth_number' => 11, 'crown_status' => 0, 'root_status' => 0],
                ['tooth_number' => 12, 'crown_status' => 1, 'root_status' => 0],
                ['tooth_number' => 21, 'crown_status' => 0, 'root_status' => 0],
            ]);

            // إضافة فحص ثاني لمريض مختلف
            $exam2 = DentalExamination::create([
                'family_member_id' => 2, 
                'doctor_id' => 1,
                'occupation' => 'Teacher',
                'location_type' => 2,
                'extra_oral_exam' => 1,
                'tmj_symptom' => 1,
                'tmj_signs' => 0,
                'tmj_clicking' => true,
                'tmj_tenderness' => false,
                'tmj_reduced_mobility' => false,
                'mucosa_condition' => 1,
                'mucosa_location' => 2,
                'cpi_sections' => ["1", "2", "1", "0", "0", "X"],
                'fluorosis_index' => 1,
                'trauma_index' => 0,
                'occlusion_class' => 2,
            ]);

            $exam2->toothStatuses()->createMany([
                ['tooth_number' => 31, 'crown_status' => 0, 'root_status' => 0],
                ['tooth_number' => 32, 'crown_status' => 2, 'root_status' => 0],
            ]);
        });
    }
}
