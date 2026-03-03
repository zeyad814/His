<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\FamilyMember;
use App\Models\PremaritalScreening;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PremaritalScreeningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $doctor = Doctor::first();
        $member = FamilyMember::first();

        if ($doctor && $member) {
            PremaritalScreening::create([
                'family_member_id' => $member->id,
                'doctor_id'        => $doctor->id,
                'type'             => ($member->is_male == 1) ? 'groom' : 'bride',
                'consanguinity'    => false,
                'chronic_diseases' => 'None',
                'blood_pressure'   => '120/80',
                'pulse'            => 75,
                'weight'           => 70.5,
                'height'           => 175,
                'bmi'              => 23.0,
                'blood_sugar'      => '90 mg/dL',
                'hemoglobin_level' => '14.5',
                'examination_date' => now(),
            ]);
        }
    }
}
