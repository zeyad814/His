<?php

namespace Database\Seeders;

use App\Models\AssessmentQuestion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssessmentQuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questions = [
            // --- 1. الوهن (Frailty) ---
            ['category' => 'Frailty', 'key_name' => 'f_weight_loss', 'question_text' => 'هل فقدت 5 كجم أو أكثر من وزنك خلال العام الماضي؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Frailty', 'key_name' => 'f_exhaustion', 'question_text' => 'هل تشعر بالإرهاق أو التعب الشديد أغلب الوقت؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Frailty', 'key_name' => 'f_slowness', 'question_text' => 'هل تجد صعوبة أو بطء ملحوظ أثناء المشي؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Frailty', 'key_name' => 'f_weakness', 'question_text' => 'هل تشعر بضعف في قبضة اليد أو القوة البدنية؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Frailty', 'key_name' => 'f_inactivity', 'question_text' => 'هل يقل نشاطك البدني اليومي عن المعتاد؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Frailty', 'key_name' => 'f_comments', 'question_text' => 'ملاحظات قسم الوهن', 'input_type' => 'text', 'options' => null],

            // --- 2. الأنشطة اليومية (ADL) - نظام النقاط 0-1-2 ---
            ['category' => 'ADL', 'key_name' => 'adl_bathing', 'question_text' => 'الاستحمام', 'input_type' => 'select', 'options' => ['0' => 'يعتمد كلياً', '1' => 'يحتاج مساعدة', '2' => 'مستقل']],
            ['category' => 'ADL', 'key_name' => 'adl_dressing', 'question_text' => 'ارتداء الملابس', 'input_type' => 'select', 'options' => ['0' => 'يعتمد كلياً', '1' => 'يحتاج مساعدة', '2' => 'مستقل']],
            ['category' => 'ADL', 'key_name' => 'adl_toileting', 'question_text' => 'استخدام المرحاض', 'input_type' => 'select', 'options' => ['0' => 'يعتمد كلياً', '1' => 'يحتاج مساعدة', '2' => 'مستقل']],
            ['category' => 'ADL', 'key_name' => 'adl_transferring', 'question_text' => 'الانتقال من السرير للكرسي', 'input_type' => 'select', 'options' => ['0' => 'يعتمد كلياً', '1' => 'يحتاج مساعدة', '2' => 'مستقل']],
            ['category' => 'ADL', 'key_name' => 'adl_eating', 'question_text' => 'تناول الطعام', 'input_type' => 'select', 'options' => ['0' => 'يعتمد كلياً', '1' => 'يحتاج مساعدة', '2' => 'مستقل']],

            // --- 3. الحالة المزاجية والذهنية (Mood & Cognitive) ---
            ['category' => 'Mood', 'key_name' => 'm_depression', 'question_text' => 'هل تشعر بالحزن أو الاكتئاب مؤخراً؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Mood', 'key_name' => 'm_anxiety', 'question_text' => 'هل تعاني من قلق مستمر أو توتر؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Cognitive', 'key_name' => 'c_mini_cog', 'question_text' => 'نتيجة اختبار Mini-Cog (من 5 نقاط)', 'input_type' => 'integer', 'options' => null],

            // --- 4. الحواس والتنقل (Senses & Mobility) ---
            ['category' => 'Senses', 'key_name' => 's_vision', 'question_text' => 'هل توجد مشاكل في الرؤية تؤثر على الأنشطة؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Senses', 'key_name' => 's_hearing', 'question_text' => 'هل توجد مشاكل في السمع؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Mobility', 'key_name' => 'mob_falls', 'question_text' => 'هل تعرضت للسقوط خلال الـ 6 أشهر الماضية؟', 'input_type' => 'boolean', 'options' => null],
            
            // --- 5. التطعيمات والفحوصات (Vaccines & Screening) ---
            ['category' => 'Vaccines', 'key_name' => 'v_influenza', 'question_text' => 'هل تلقيت مصل الإنفلونزا الموسمية؟', 'input_type' => 'boolean', 'options' => null],
            ['category' => 'Screening', 'key_name' => 'sc_hypertension', 'question_text' => 'فحص ضغط الدم الدوري', 'input_type' => 'boolean', 'options' => null],
        ];

        foreach ($questions as $question) {
            AssessmentQuestion::updateOrCreate(
                ['key_name' => $question['key_name']], // لو السؤال موجود يعدله، لو مش موجود يكريته
                $question
            );
        }
    }
}
