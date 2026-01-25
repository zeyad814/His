<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->count(3)->create()->each(function ($admin) {
            User::factory()->create([
                'name' => 'Admin',
                'email' => 'admin'.$admin->id.'@example.com',
                'role' => 'admin',
                'userable_id' => $admin->id,
                'userable_type' => Admin::class,
                'password' => Hash::make('password'),
            ]);
        });
    }
}
