<?php

namespace Database\Seeders;

use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class NurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $nurse = Nurse::create([
            'national_id' => '29501011234567',
            'phone' => '01099887766',
            'start_date' => '2020-01-01',
            'health_unit_id' => 1,
        ]);

        // 2. ننشئ اليوزر المرتبط بها باستخدام علاقة الـ Morph
        $nurse->user()->create([
            'name' => 'مريم محمد علي',
            'email' => 'nurse1@app.com',
            'password' => Hash::make('password'), // كلمة السر
            'role' => 'nurse', // أو 'data' حسب اللي مستخدمه
        ]);
    }
}
