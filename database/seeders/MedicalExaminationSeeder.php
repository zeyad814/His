<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use App\Models\GeneralExamination;
use App\Models\PhysicalExamination;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicalExaminationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $firstMember = FamilyMember::orderBy('id', 'asc')->first();
        if ($firstMember)
        {
            PhysicalExamination::factory()
                ->has(GeneralExamination::factory())
                ->create([
                    'family_member_id' => $firstMember->id
                ]);

            $this->command->info('Success: Seeder linked to family member ID: ' . $firstMember->id);
        }
        else
        {
            $this->command->error('Error: No family members found! Please seed family_members table first.');
        }
    }
}
