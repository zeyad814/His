<?php

namespace Database\Seeders;

use App\Models\ChronicDisease;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChronicDiseaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChronicDisease::insert([
            [
                'family_member_id' => 1,
                'diagnosis' => 'Diabetes',
                'date_diagnosed' => '2025-06-01',
                'risk_factors' => 'Obesity, Family history',
            ],
            [
                'family_member_id' => 2,
                'diagnosis' => 'Hypertension',
                'date_diagnosed' => '2025-05-15',
                'risk_factors' => 'High salt diet, Smoking',
            ],
        ]);
    }
}
