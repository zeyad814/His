<?php

namespace Database\Seeders;

use App\Models\Doctor;
use App\Models\User;
use Database\Seeders\AdminSeeder;
use Database\Seeders\BirthScreeningSeeder;
use Database\Seeders\ChronicDiseaseSeeder;
use Database\Seeders\ClinicalExaminationSeeder;
use Database\Seeders\DevelopmentalMilestoneSeeder;
use Database\Seeders\DiabetesFollowUpSeeder;
use Database\Seeders\FamilyFullProcessSeeder;
use Database\Seeders\HypertensionFollowUpSeeder;
use Database\Seeders\MedicalExaminationSeeder;
use Database\Seeders\PostnatalCareSeeder;
use Database\Seeders\PregnancySeeder;
use Database\Seeders\PregnancyVisitSeeder;
use Database\Seeders\SignificantDataSeeder;
use Database\Seeders\VisitSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(DoctorSeeder::class);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'userable_id' => Doctor::first()->id,
            'userable_type' => \App\Models\Doctor::class,
        ]);

        $this->call([
            AdminSeeder::class,
            FamilyFullProcessSeeder::class,
            MedicalExaminationSeeder::class,
            SignificantDataSeeder::class,
            VisitSeeder::class,
            HypertensionFollowUpSeeder::class,
            DiabetesFollowUpSeeder::class,
            ChronicDiseaseSeeder::class,
            ClinicalExaminationSeeder::class,
            DevelopmentalMilestoneSeeder::class,
            PregnancySeeder::class,
            PregnancyVisitSeeder::class,
            BirthScreeningSeeder::class,
            PostnatalCareSeeder::class,
            PsychologicalSupportVisitSeeder::class,
            FamilyPlanningSeeder::class,
            FamilyPlanningFollowUpSeeder::class,
            CvRiskAssessmentSeeder::class,
        ]);
    }
}
