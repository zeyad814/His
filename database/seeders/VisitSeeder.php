<?php

namespace Database\Seeders;

use App\Models\Visit;
use App\Models\FamilyMember;
use App\Models\Doctor;
use Illuminate\Database\Seeder;

class VisitSeeder extends Seeder
{
    public function run(): void
    {
        // جلب أول فرد فقط
        $firstMemberId = FamilyMember::first()->id;
        $doctors = Doctor::pluck('id')->toArray();

        // أنواع الزيارات الأخرى
        $otherVisitTypes = ['متابعة الحمل', 'تنظيم الأسرة', 'متابعة طفل', 'زيارة دورية', 'أسنان'];

        for ($i = 0; $i < 20; $i++)
        {
            // منطق تحديد نوع الزيارة
            if ($i < 2) {
                $currentType = 'أمراض مزمنة';
            } 
            elseif ($i === 6) { 
                // الإدخال رقم 7 (لأن العد يبدأ من 0)
                $currentType = 'متابعة طفل';
            } 
            else {
                $currentType = $otherVisitTypes[array_rand($otherVisitTypes)];
            }

            Visit::create([
                'family_member_id' => $firstMemberId,
                'doctor_id' => $doctors[array_rand($doctors)],
                'date' => now()->subDays(rand(0, 30)),
                'visit_type' => $currentType,
                'complaint' => 'يعاني المريض من ' . $this->getRandomComplaint(),
                'clinical_examination' => 'بالفحص السريري تبين أن الحالة مستقرة والنبض منتظم.',
                'investigations' => 'تحليل دم كامل، رسم قلب.',
                'diagnoses' => 'تشخيص أولي: ' . $this->getRandomDiagnosis(),
                'management_follow_up' => 'متابعة بعد أسبوع مع الالتزام بالراحة التامة.',
            ]);
        }
    }

    private function getRandomComplaint()
    {
        $complaints = ['صداع مزمن', 'آلام في المفاصل', 'ارتفاع طفيف في الحرارة', 'إرهاق عام'];
        return $complaints[array_rand($complaints)];
    }

    private function getRandomDiagnosis()
    {
        $diagnoses = ['اشتباه ضغط دم مرتفع', 'إجهاد عضلي', 'أنيميا بسيطة', 'تحتاج لمتابعة دورية'];
        return $diagnoses[array_rand($diagnoses)];
    }
}