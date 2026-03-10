<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CriticalResult>
 */
class CriticalResultFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $visit = \App\Models\Visit::where('visit_type', 'زيارة دورية')->inRandomOrder()->first();

        return [
            'family_member_id' => 1,
            'visit_id' => $visit ? $visit->id : \App\Models\Visit::factory()->create(['visit_type' => 'زيارة دورية'])->id,
            'test_type_and_value' => $this->faker->randomElement([
                'Glucose: 450 mg/dL',
                'Potassium: 6.8 mmol/L',
                'Hemoglobin: 6.2 g/dL'
            ]),
            'result_generated_at' => now()->subMinutes(30),
            'notified_at' => now()->subMinutes(25),
            'notification_method' => 'telephone',
            'receiving_clinic' => 'ICU',
            'notifier_id' => \App\Models\Doctor::inRandomOrder()->first()?->id,
            'recipient_id' => \App\Models\Doctor::inRandomOrder()->first()?->id,
            'is_accepted' => null,
        ];
    }
}
