<?php

namespace Database\Seeders;

use App\Models\HealthAdministration;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthAdministrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HealthAdministration::create([
        'name' => 'إدارة وسط الطبية',
        'address' => 'شارع البحر، القاهرة',
        'email' => 'admin@health.gov.eg',
        'phone' => '022345678'
    ]);
    }
}
