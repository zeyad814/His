<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\PostnatalCare;
use App\Models\Pregnancy;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostnatalCareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pregnancy = Pregnancy::first();
        $doctor = Doctor::first();

        if ($pregnancy && $doctor) {
            PostnatalCare::create([
                'pregnancy_id' => $pregnancy->id,
                'doctor_id'    => $doctor->id,
                'visit_date'   => now()->format('Y-m-d'),

                // بيانات الولادة
                'delivery_type' => 'natural',
                'delivery_date' => now()->subDays(10)->format('Y-m-d'), 
                'baby_status'   => 'alive',
                'delivery_place' => 'مستشفى الشفاء',
                'attended_by'    => 'د. أحمد علي',

                // التقييم الطبي
                'breastfeeding_type'       => 'Exclusive',
                'breastfeeding_assessment' => 'Good latching',
                'depression_screening'     => 'No signs of depression',
                'social_adjustment'        => 'Well adjusted with family',
                
                // تنظيم الأسرة
                'contraception_method' => 'IUD (اللولب)',
                'contraception_date'   => now()->format('Y-m-d'),
            ]);
        }
    }
}
