<?php

namespace Database\Seeders;

use App\Models\ChronicDiseaseVisit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ChronicDiseaseVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChronicDiseaseVisit::create([
        'visit_id'           => 1, // حطي ID موجود فعلاً
        'chronic_disease_id' => 1, // حطي ID موجود فعلاً
        'doctor_id'          => 4, // حطي ID موجود فعلاً
        'complain'           => 'الصداع مستمر بقاله يومين',
        'exam'               => 'الضغط عالي 160/100',
        'vital_signs'        => 'BP: 160/100',
        'investigations'     => 'تحليل بول كامل',
        'management'         => 'علاج ضغط طوارئ',
        'notes'              => 'متابعة بعد 24 ساعة',
        'visit_date'         => now(),
    ]);
    }
}
