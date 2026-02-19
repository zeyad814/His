<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\FamilyMember;
use App\Models\FamilyPlanning;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyPlanningSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = FamilyMember::first();
        $doctor = Doctor::first();

        if ($member && $doctor) {
            FamilyPlanning::create([
                'family_member_id' => $member->id,
                'doctor_id'        => $doctor->id,
                'registration_date' => Carbon::now()->subMonths(2), // من شهرين

                // تاريخ إنجابي تجريبي
                'pregnancies_count'    => 3,
                'abortions_count'      => 1,
                'alive_children_count' => 2,
                'oldest_child_age'     => 5,
                'youngest_child_age'   => 2,
                'last_delivery_or_abortion_date' => Carbon::now()->subYears(2),

                'has_fever_or_discharge' => false,
                'is_breastfeeding'       => true,

                // الوسائل
                'is_using_contraception_now' => true,
                'current_method_name'        => 'IUD (اللولب)',
                'used_contraception_before'  => true,
                'previous_method_name'       => 'Combined Oral Contraceptives',

                // الفحص الطبي
                'vaginal_scaring_or_ulcer' => false,
                'vaginal_discharge'        => false,
                'prolapse'                 => false,
                'uterus_position'          => 'anteverted',
                'uterus_size'              => 'normal',
                'cervix_status'            => 'Normal healthy cervix',
                'conclusion'               => 'Patient is fit for IUD follow-up',
            ]);
        }
    }
}
