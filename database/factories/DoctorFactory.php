<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Family;
use App\Models\HealthUnit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $order = 0;
        $specializations = ['family', 'dentist', 'family', 'dentist', 'dentist'];
        
        $spec = $specializations[$order % count($specializations)];
        $order++;

        return [
            // 'family_id' => Family::inRandomOrder(null)->first()?->id,
            'health_unit_id' => HealthUnit::inRandomOrder(null)->first()?->id,
            'national_id' => $this->faker->unique()->numerify('##############'),
            'phone' => $this->faker->phoneNumber(),
            'specialization' => $spec,
            'license_number' => $this->faker->numerify('LIC#####'),
            'start_date' => $this->faker->date(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Doctor $doctor) {
            // إنشاء مستخدم وربطه بالدكتور (Polymorphic Relation)
            User::factory()->create([
                'name' => $this->faker->name(), // أو ثبت اسم معين للتجربة
                'userable_id' => $doctor->id,
                'userable_type' => Doctor::class, // هيتخزن كـ App\Models\Doctor
            ]);
        });
    }
}
