<?php

namespace Database\Seeders;

use App\Models\FamilyPlanningFollowUp;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FamilyPlanningFollowUpSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FamilyPlanningFollowUp::create([
            'family_planning_id' => 1, 
            'doctor_id' => 1,          
            'visit_date' => now()->format('Y-m-d'),
            'get_method' => true,
            'dispensed_method' => 'Pills',
            'quantity' => 3,
            'next_visit_date' => now()->addMonth()->format('Y-m-d'),
            'notes' => 'المريضة بحالة جيدة واستلمت 3 شريط حبوب',
        ]);
    }
}
