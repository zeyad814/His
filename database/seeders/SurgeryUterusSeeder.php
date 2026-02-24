<?php

namespace Database\Seeders;

use App\Models\FamilyPlanning;
use App\Models\SurgeryUterus;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SurgeryUterusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $familyPlanning = FamilyPlanning::first();
        $doctor = User::where('role', 'doctor')->first() ?? User::first();
        $nurse = User::where('role', 'nurse')->first() ?? User::first();

        // 1. إنشاء العملية أولاً وحفظها في متغير
        $surgery = SurgeryUterus::create([
            'family_planning_id' => $familyPlanning?->id ?? 1,
            'doctor_id' => $doctor?->id ?? 1,
            'nurse_id' => $nurse?->id ?? 1,
            'diagnosis' => 'حالة تركيب لولب نحاسي - متابعة دورية',
            'patient_age' => 27,
            'procedure_type' => 'IUD_insertion',
            'site_side' => 'N/A',
            'patient_identity_verified' => true,
            'informed_consent_signed' => true,
            'procedure_site_marked' => false,
            'equipment_sterilization_verified' => true,
            'supplies_availability_verified' => true,
            'pregnancy_test_done' => true,
            'hemoglobin_test_done' => true,
            'final_team_verification' => true,
            'procedure_date' => now()->format('Y-m-d'),
            'procedure_time' => '12:00',
        ]);

        
        $surgery->equipments()->createMany([
            ['name' => 'Vaginal Speculum (منظار مهبلي)', 'status' => 'Used'],
            ['name' => 'Tenaculum Forceps (جفت معقم)', 'status' => 'Used'],
            ['name' => 'Uterine Sound (مسبار رحم)', 'status' => 'Used'],
            ['name' => 'IUD Kit', 'status' => 'Used'],
        ]);

        
        $implantSurgery = SurgeryUterus::create([
            'family_planning_id' => $familyPlanning?->id ?? 1,
            'doctor_id' => $doctor?->id ?? 1,
            'nurse_id' => $nurse?->id ?? 1,
            'diagnosis' => 'تركيب كبسولة لمنع الحمل',
            'patient_age' => 32,
            'procedure_type' => 'Implant_insertion',
            'procedure_date' => now()->subDay()->format('Y-m-d'),
            'procedure_time' => '10:30',
        ]);

        $implantSurgery->equipments()->createMany([
            ['name' => 'Local Anesthesia', 'status' => 'Used'],
            ['name' => 'Trocar', 'status' => 'Used'],
            ['name' => 'Implant Rod', 'status' => 'Used'],
        ]);
    }
}
    

