<?php

namespace Database\Seeders;

use App\Models\FamilyPlanning;
use App\Models\SurgeryUterus;
use App\Models\Doctor; // تأكد من استدعاء الموديل
use App\Models\Nurse;  // تأكد من استدعاء الموديل
use Illuminate\Database\Seeder;

class SurgeryUterusSeeder extends Seeder
{
    public function run(): void
    {
        // هات أول سجل متاح من كل جدول
        $familyPlanning = FamilyPlanning::first();
        
        // هات ID الدكتور من جدول الـ doctors والـ ممرضة من جدول الـ nurses
        $doctor = Doctor::first();
        $nurse = Nurse::first();

        // لو الجداول فاضية، الـ Seeder هيضرب، فممكن تعمل check بسيط
        if (!$doctor || !$nurse) {
            $this->command->error("برجاء تشغيل DoctorSeeder و NurseSeeder أولاً!");
            return;
        }

        // 1. إنشاء عملية تركيب لولب
        $surgery = SurgeryUterus::create([
            'family_planning_id' => $familyPlanning?->id ?? 1,
            'doctor_id' => $doctor->id, // ID من جدول doctors
            'nurse_id' => $nurse->id,   // ID من جدول nurses
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

        // 2. إنشاء عملية تركيب كبسولة
        $implantSurgery = SurgeryUterus::create([
            'family_planning_id' => $familyPlanning?->id ?? 1,
            'doctor_id' => $doctor->id,
            'nurse_id' => $nurse->id,
            'diagnosis' => 'تركيب كبسولة لمنع الحمل',
            'patient_age' => 32,
            'procedure_type' => 'Implant_insertion',
            'procedure_date' => now()->subDay()->format('Y-m-d'),
            'procedure_time' => '10:30',
            // ضيف باقي الحقول المطلوبة لو الـ Migration بيطلبها (زي الـ booleans اللي فوق)
            'patient_identity_verified' => true,
            'informed_consent_signed' => true,
        ]);

        $implantSurgery->equipments()->createMany([
            ['name' => 'Local Anesthesia', 'status' => 'Used'],
            ['name' => 'Trocar', 'status' => 'Used'],
            ['name' => 'Implant Rod', 'status' => 'Used'],
        ]);
    }
}