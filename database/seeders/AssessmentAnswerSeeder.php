<?php

namespace Database\Seeders;

use App\Models\AssessmentAnswer;
use App\Models\AssessmentQuestion;
use App\Models\Doctor;
use App\Models\FamilyMember;
use App\Models\GeriatricAssessment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $familyMember = FamilyMember::first();
        $doctor = Doctor::first();

        // 2. نكريت "رأس" الاستمارة (التقييم الأساسي)
        $assessment = GeriatricAssessment::create([
            'family_member_id' => $familyMember->id,
            'doctor_id'        => $doctor->id,
            'overall_status'   => 'Stable',
            'doctor_recommendations' => 'Keep healthy diet and regular exercise.',
        ]);

        // 3. نجيب كل الأسئلة اللي لسه ضايفينها في الجدول التاني
        $questions = AssessmentQuestion::all();

        // 4. نلف على كل سؤال ونحط له إجابة وهمية بناءً على نوعه
        foreach ($questions as $question) {
            $answerValue = '';

            if ($question->input_type === 'boolean') {
                $answerValue = collect(['true', 'false'])->random();
            } elseif ($question->input_type === 'select') {
                // لو هو ADL مثلاً بيختار 0 أو 1 أو 2
                $answerValue = collect(['0', '1', '2'])->random();
            } elseif ($question->input_type === 'integer') {
                $answerValue = (string)rand(1, 5);
            } else {
                $answerValue = 'Sample medical note for ' . $question->key_name;
            }

            AssessmentAnswer::create([
                'geriatric_assessment_id' => $assessment->id,
                'assessment_question_id'  => $question->id,
                'answer_value'            => $answerValue,
            ]);
        }
    }
}
