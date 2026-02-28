<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\FamilyInjection;
use App\Models\FamilyMember;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyInjectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $doctor = Doctor::first();
        $member = FamilyMember::first();

        
        if ($doctor && $member) {
            FamilyInjection::create([
                'family_member_id' => $member->id,
                'doctor_id'        => $doctor->id,
                'procedure_name'   => 'Depo-Provera (3-Month Injection)',
                'phone'            => '01012345678',
                'is_agreed'        => true, 
                'visit_date'       => Carbon::now()->format('Y-m-d'),
                'visit_time'       => Carbon::now()->format('H:i:s'),
                'signature_path'   => null, 
            ]);

            $this->command->info('Family Injection seeded successfully!');
        } else {
            $this->command->error('Please seed Doctors and FamilyMembers first!');
        }
    }
}
