<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SignificantData>
 */
class SignificantDataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'doctor_id' => Doctor::first()?->id ?? Doctor::factory(),
            'family_member_id' => FamilyMember::first()?->id ?? FamilyMember::factory(),
            'record_date' => $this->faker->date(),
            'case_description' => $this->faker->paragraph(2),
            'action_doctor_name' => 'Dr. ' . $this->faker->name(),
        ];
    }
}
