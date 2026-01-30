<?php

namespace Database\Factories;

use App\Models\PhysicalExamination;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GeneralExamination>
 */
class GeneralExaminationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'physical_examination_id' => PhysicalExamination::factory(),
            'blood_pressure' => '120/80',
            'pulse' => '75',
            'temperature' => '37.2',
            'respiratory_rate' => '18',
            'height' => '175',
            'weight' => '70',
            'bmi' => '22.8',
            'skin_complexion' => ['jaundice' => false, 'cyanosis' => false, 'pallor' => 'none'],
            'head_neck' => ['fontanels' => 'closed', 'sutures' => 'normal'],
            'heart' => ['sounds' => 'normal S1, S2', 'murmurs' => 'none'],
            'chest' => ['breathing' => 'vesicular', 'expansion' => 'equal'],
            'abdomen' => ['liver' => 'not palpable', 'spleen' => 'normal'],
            'neurological' => ['motor' => 'intact', 'sensory' => 'normal'],
            'upper_limb' => ['power' => '5/5'],
            'lower_limb' => ['edema' => 'absent'],
            'disabilities' => ['status' => 'none'],
            'eyes' => ['right' => '6/6', 'left' => '6/6', 'result' => 'normal'],
            'ent' => ['hearing' => 'normal', 'nose' => 'clear'],
            'risk_factors' => ['obesity' => false, 'smoking' => true],
            'lab_results' => ['HB' => '14.5', 'WBC' => '7000'],
            'general_appearance' => 'Patient is alert and oriented',
            'pain_assessment' => 'No pain',
            'deformities' => 'None',
            'nutritional_assessment' => 'Well nourished',
            'conclusion' => 'Overall health is stable.',
        ];
    }
}
