<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use App\Models\SignificantData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SignificantDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $member = FamilyMember::first();
        if ($member)
        {
            SignificantData::factory()->count(3)->create([
                'family_member_id' => $member->id
            ]);

            $this->command->info('Success: 3 Significant data records created for member ID: ' . $member->id);
        }
        else
        {
            $this->command->error('Error: No family members found for SignificantDataSeeder.');
        }
    }
}
