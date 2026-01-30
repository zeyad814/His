<?php

namespace Database\Seeders;

use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class FamilySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // تعطيل FK مؤقتًا لمسح البيانات القديمة
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('family_members')->truncate();
        DB::table('families')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // إضافة بيانات العائلات
        $family1 = Family::create([
            'family_code' => 'FAM001',
            'national_id' => '12345678901234',
            'head_name' => 'Ahmed Ali',
            'governorate' => 'kafr El Sheikh',
            'health_department' => 'Health Dept 1',
            'village_or_city' => 'Sidi Salem',
            'health_unit' => 'Unit 1',
            'address' => 'Street 123',
            'mobile_phone' => '01000000001',
            'work_phone' => '0220000001',
            'nearest_phone' => '01000000002',
            'family_doctor_id' => 1,
            'family_doctor_assign_date' => '2026-01-01',
            'dentist_id' => 2,
            'dentist_assign_date' => '2026-01-02'
        ]);

        // إضافة أعضاء العائلة
        FamilyMember::create([
            'full_name' => 'Ali Ahmed',
            'is_male' => true,
            'birth_date' => '1995-03-15',
            'relationship_to_head' => 'Son',
            'insurance_type' => 'Private',
            'notes' => 'لا توجد ملاحظات',
            'family_id' => $family1->id
        ]);

        FamilyMember::create([
            'full_name' => 'Fatma Ahmed',
            'is_male' => false,
            'birth_date' => '1998-07-20',
            'relationship_to_head' => 'Daughter',
            'insurance_type' => 'Public',
            'notes' => 'لا توجد ملاحظات',
            'family_id' => $family1->id
        ]);
    }
}
