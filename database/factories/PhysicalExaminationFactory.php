<?php

namespace Database\Factories;

use App\Models\FamilyMember;
use App\Models\PhysicalExamination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhysicalExamination>
 */
class PhysicalExaminationFactory extends Factory
{
    protected $model = PhysicalExamination::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // قائمة الأمراض المتاحة في الـ UI للاختيار العشوائي منها
        $diseases = ['TB', 'Asthma', 'Cardiac', 'Consanguinity', 'Diabetes', 'Hypertension', 'Renal', 'Blood Dis.', 'Twins', 'Epilepsy', 'Cancer', 'Congenital anomalies', 'Psychiatric'];

        return [
            'family_member_id' => FamilyMember::inRandomOrder()->first()?->id ?? FamilyMember::factory(),
            
            // Medical History (Text Fields)
            'hospitalization' => $this->faker->optional(0.7)->sentence(), // 70% probability of having data
            'previous_operations' => $this->faker->optional(0.5)->words(3, true),
            'current_medication' => $this->faker->optional(0.6)->words(2, true),
            'trauma_injuries' => $this->faker->optional(0.3)->sentence(),
            
            // Medical History (Booleans)
            'has_allergy' => $this->faker->boolean(20), // 20% chance of true
            'has_adverse_drug_reaction' => $this->faker->boolean(10),
            'has_abuse_negligence' => $this->faker->boolean(5),

            // Special Habits
            'habit_smoking' => $this->faker->boolean(40),
            'habit_alcohol' => $this->faker->boolean(15),
            'habit_other' => $this->faker->optional(0.2)->sentence(),

            // Psychiatric History
            'psych_irrelevant' => $this->faker->boolean(80),
            'psych_follow_up' => $this->faker->boolean(10),
            'psych_medical_treatment' => $this->faker->boolean(10),
            'psych_other' => $this->faker->optional(0.1)->sentence(),

            // Family History
            'family_diseases' => $this->faker->randomElements($diseases, $this->faker->numberBetween(0, 3)),
            'family_history_other' => $this->faker->optional(0.4)->sentence(),
        ];
    }
}