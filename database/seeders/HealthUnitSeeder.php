<?php

namespace Database\Seeders;

use App\Models\HealthUnit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthUnitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HealthUnit::create([
        'health_administration_id' => 1,
        'name' => 'وحدة صحة الأسرة (أ)',
        'address' => 'مصر الجديدة',
        'email' => 'unit1@health.gov.eg',
        'phone' => '0123456789'
    ]);
    }
}
