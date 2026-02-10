<?php

namespace Database\Seeders;

use App\Models\Pregnancy;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PregnancySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pregnancy::create([
            'family_member_id' => 1,
            'last_menstrual_period' => '2023-10-01',
            'expected_delivery_date' => '2024-07-07',
            'pregnancy_status' => 'current',
            'gravidity' => 3,     // حملت 3 مرات
            'parity' => 2,        // ولدت مرتين
            'abortions' => 0,     // مفيش إجهاض
            'living_children' => 2,
            'previous_stillbirths' => 0,
            'previous_cesarean' => 1, // والدة مرة قيصري قبل كدة
            'blood_type' => 'O+',
            'rh_factor' => 'Positive',
            'syphilis_test_result' => 'Negative',
            'last_tetanus_date' => '2023-01-01',
            'tetanus_doses' => 2,
            'tetanus_immunity_status' => 'Immune',
            'consanguinity' => false, // لا يوجد صلة قرابة
        ]);
    }
}
