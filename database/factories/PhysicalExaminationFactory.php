<?php

namespace Database\Factories;

use App\Models\FamilyMember;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhysicalExamination>
 */
class PhysicalExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'family_member_id' => FamilyMember::orderBy('id', 'asc')->first()?->id ?? FamilyMember::factory(),
            'family_history' => $this->faker->sentence(),
            'hospitalization' => 'Previously hospitalized in 2023 for appendectomy',
            'lab_tests_results' => 'CBC and Glucose within normal ranges',
            'special_habits' => 'Smoker (5 cigarettes/day)',
            'previous_operations' => 'Appendectomy',
            'current_medication' => 'None',
            'trauma_injuries' => 'None',
            'allergy' => 'Dust allergy',
            'adverse_drug_reaction' => 'None',
            'abuse_negligence' => 'Negative',
            'psychiatric_history' => 'No prior psychiatric issues',
        ];
    }
}
