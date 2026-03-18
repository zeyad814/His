<?php

namespace Database\Seeders;

use App\Models\SuperAdmin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $super = SuperAdmin::create([
            'employee_number' => 'SA-2026-001',
            'phone' => '123456789',
        ]);

        $super->user()->create([
            'name' => 'Eng. Ahmed',
            'email' => 'super@app.com',
            'password' => Hash::make('password'),
            'role' => 'super_admin',
        ]);
    }
}
