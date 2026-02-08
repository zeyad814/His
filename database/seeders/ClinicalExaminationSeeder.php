<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ClinicalExamination;

class ClinicalExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $visitIds = [4, 6, 15, 17];
        
        foreach ($visitIds as $id)
        {
            ClinicalExamination::create([
                'family_member_id' => 1,
                'visit_id' => $id,
                'visit_date' => "2026-02-0" . ($id % 9 + 1),
                'age_stage' => "2",
                'clinical_assessment' => "النمو الحركي سليم، ضربات القلب منتظمة، ولا توجد علامات سوء تغذية لزيارة رقم $id.",
                'parental_concern' => "الأم تلاحظ بكاء مستمر بعد الرضاعة.",
                'health_education' => "تم التوجيه بوضعية الرضاعة الصحيحة وكيفية التعامل مع المغص.",
                'notes' => "يتم المتابعة في الزيارة القادمة للتأكد من استقرار الوزن لزيارة رقم $id.",
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
