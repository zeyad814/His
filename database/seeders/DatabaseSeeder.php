<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(DoctorSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'userable_id' => Doctor::first()->id,
            'userable_type' => \App\Models\Doctor::class,
        ]);
        $this->call(AdminSeeder::class);
        $this->call(FamilyFullProcessSeeder::class);
    }
}
