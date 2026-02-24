<?php

namespace Database\Seeders;

use App\Models\Nurse;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NurseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Nurse::create([
        'health_unit_id' => 1,
        'national_id' => '29501011234567',
        'name' => 'مريم محمد علي',
        'phone' => '01099887766',
        'start_date' => '2020-01-01'
    ]);
    }
}
