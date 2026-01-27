<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Doctor;
use App\Models\MedicalHistory;
use App\Models\DeathRecord;
use App\Models\HousingInfo;
use App\Models\SocialResearch;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class FamilyFullProcessSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('en_US');

        if (Doctor::count() < 2) {
            $this->command->error('Please seed Doctors first!');
            return;
        }

        for ($i = 0; $i < 10; $i++) {
            DB::beginTransaction();
            try {
                // 1. Core Family Data
                $family = Family::create([
                    'family_code'       => 'FAM-' . $faker->unique()->numerify('######'),
                    'national_id'       => $faker->unique()->numerify('29#########456'),
                    'head_name'         => $faker->name('male'),
                    'governorate'       => $faker->state,
                    'village_or_city'   => $faker->city,
                    'health_department' => 'Dept ' . $faker->word,
                    'health_unit'       => 'Unit ' . $faker->buildingNumber,
                    'address'           => $faker->streetAddress,
                    'mobile_phone'      => $faker->numerify('010########'),
                    'work_phone'        => $faker->numerify('011########'),
                    'nearest_phone'     => $faker->numerify('012########'),
                ]);

                // 2. Family Members (Matches your JSON 'relationship_to_head' Enum)
                $membersData = [
                    ['rel' => 'father', 'sex' => 'male'],
                    ['rel' => 'wife', 'sex' => 'female']
                ];

                $createdMembers = [];
                foreach ($membersData as $data) {
                    $createdMembers[] = FamilyMember::create([
                        'family_id'            => $family->id,
                        'full_name'            => $faker->name($data['sex']),
                        'is_male'              => ($data['sex'] === 'male'),
                        'birth_date'           => $faker->date('Y-m-d', '-30 years'),
                        'relationship_to_head' => $data['rel'],
                        'insurance_type'       => $faker->randomElement(['public', 'private']),
                    ]);
                }

                // 3. Assign Doctors (Corrected Column Names)
                $fDoctor = Doctor::where('specialization', 'family')->inRandomOrder()->first();
                $dDoctor = Doctor::where('specialization', 'dentist')->inRandomOrder()->first();

                // ملاحظة: استبدلت أسامي الحقول بـ _assign_date لتعمل مع الـ SQL الخاص بك
                $family->update([
                    'family_doctor_id'          => $fDoctor?->id,
                    'family_doctor_assign_date' => now()->format('Y-m-d'),
                    'dentist_id'                => $dDoctor?->id,
                    'dentist_assign_date'       => now()->format('Y-m-d'),
                ]);

                // 4. Housing Info
                HousingInfo::create([
                    'family_id'                => $family->id,
                    'rooms_count'              => 3,
                    'sleeping_rooms_specified' => 2,
                    'ventilation'              => 'good',
                    'water_source'             => 'public',
                    'sanitation_type'          => 'sanitary',
                    'lighting_type'            => 'electricity',
                    'has_animals'              => true,
                    'barn_location'            => 'inside'
                ]);

                // 5. Social Research
                SocialResearch::create([
                    'family_id'                 => $family->id,
                    'income_type'               => 'fixed',
                    'avg_income'                => 7500.50,
                    'has_chronic_diseases'      => true,
                    'has_disability'            => false,
                    'receives_pension'          => true,
                    'eligible_for_free_service' => true,
                ]);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->command->error("Seeding Error: " . $e->getMessage());
            }
        }

        $this->command->info('Success: 10 families seeded with correct columns.');
    }
}
