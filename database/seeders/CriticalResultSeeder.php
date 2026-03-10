<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CriticalResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\CriticalResult::factory()->count(5)->create();

        // 2. حالات تم قبولها (Accepted)
        \App\Models\CriticalResult::factory()->count(5)->create([
            'is_accepted' => true,
            'doctor_action' => 'Administered insulin and monitored vitals.',
            'doctor_id' => \App\Models\Doctor::inRandomOrder()->first()?->id,
        ]);

        // 3. حالات تم رفضها وعمل إعادة اختبار (Rejected & Re-tested)
        \App\Models\CriticalResult::factory()->count(3)->create([
            'is_accepted' => false,
            'second_result_value' => 'Potassium: 4.2 mmol/L (Normal)',
            'second_result_generated_at' => now(),
            'second_notified_at' => now()->addMinutes(10),
            'second_notifier_id' => \App\Models\Doctor::inRandomOrder()->first()?->id,
            'second_recipient_id' => \App\Models\Doctor::inRandomOrder()->first()?->id,
            'reporting_difficulties' => 'The first sample was hemolyzed.',
        ]);
    }
}
