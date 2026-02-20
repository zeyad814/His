<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PsychologicalSupportVisit;
use Carbon\Carbon;

class PsychologicalSupportVisitSeeder extends Seeder
{
    public function run(): void
    {
        PsychologicalSupportVisit::create([
            'family_member_id' => 1,
            'visit_date' => Carbon::now(),
            'questionnaire_type' => 'Depression Screening',
            'visit_reason' => 'Patient experiencing prolonged sadness and lack of motivation.',
            'questionnaire_result' => 'Moderate Depression',
            'initial_diagnosis' => 'Major Depressive Disorder (Moderate)',
            'treatment_plan' => 'Start CBT sessions weekly and prescribe SSRI medication.',
            'referral_location' => 'Mental Health Center - Cairo',
            'doctor_id' => 1,
        ]);
    }
}
