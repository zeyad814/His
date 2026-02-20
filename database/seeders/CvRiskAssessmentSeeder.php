<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CvRiskAssessment;
use App\Models\FamilyMember;
use App\Models\Doctor;
use Carbon\Carbon;

class CvRiskAssessmentSeeder extends Seeder
{
    public function run(): void
    {
        // بنجيب أول طبيب وأول مريض عشان نربط بيهم البيانات
        $doctor = Doctor::first();
        $familyMember = FamilyMember::first();

        if (!$doctor || !$familyMember)
        {
            $this->command->error('Please seed Doctors and FamilyMembers first!');
            return;
        }

        $data = [
            [
                'doctor_id' => $doctor->id,
                'family_member_id' => $familyMember->id,
                'assessment_date' => Carbon::now()->subDays(10),
                // Step 1: Risk Factors
                'hypertension' => true,
                'dm' => false,
                'obesity' => true,
                'smoking' => true,
                'family_history_cardiac' => false,
                // Step 2: Measurements
                'bp' => '140/90',
                'height' => 175,
                'weight' => 95,
                'cholesterol_total' => 240,
                'ldl_level' => 160,
                // Step 3: Plan
                'cv_risk_level' => 'High',
                'management_plan' => 'Start medication and strict diet.',
                'referral_to' => 'Cardiologist',
                'follow_up_date' => Carbon::now()->addMonth(),
            ],
            [
                'doctor_id' => $doctor->id,
                'family_member_id' => $familyMember->id,
                'assessment_date' => Carbon::now()->subMonths(2),
                'hypertension' => false,
                'dm' => false,
                'obesity' => false,
                'smoking' => false,
                'family_history_cardiac' => true,
                'bp' => '110/70',
                'height' => 165,
                'weight' => 60,
                'cholesterol_total' => 180,
                'ldl_level' => 100,
                'cv_risk_level' => 'Low',
                'management_plan' => 'Maintain healthy lifestyle.',
                'referral_to' => null,
                'follow_up_date' => Carbon::now()->addYear(),
            ]
        ];

        foreach ($data as $record)
        {
            CvRiskAssessment::create($record);
        }

        $this->command->info('CvRiskAssessment table seeded successfully!');
    }
}