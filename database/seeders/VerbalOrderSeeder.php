<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class VerbalOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('verbal_orders')->insert([
            'family_member_id' => 1,
            'instructions' => 'Give the patient 500mg of Paracetamol every 6 hours.',
            'order_date_time' => Carbon::now(),
            'ordered_by_doctor_id' => 1,
            'recorded_by_nurse_id' => null, // كما طلبت
            'is_confirmed' => true, // كما طلبت
            'confirmed_by_doctor_id' => 1,
            'confirmation_date_time' => Carbon::now()->addMinutes(30),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}