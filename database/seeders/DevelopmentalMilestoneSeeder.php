<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DevelopmentalMilestoneSeeder extends Seeder
{
    public function run(): void
    {
        $milestones = [
            // من شهرين إلى شهرين ونصف
            ['age_range' => 'من شهرين إلى شهرين ونصف', 'question_text_ar' => 'يُثبت الرأس في مستوى الجسم عند حمله بالعرض'],
            ['age_range' => 'من شهرين إلى شهرين ونصف', 'question_text_ar' => 'يتابع سبق الحركات البندولية للأشياء الملونة'],
            ['age_range' => 'من شهرين إلى شهرين ونصف', 'question_text_ar' => 'يصرخ'],
            ['age_range' => 'من شهرين إلى شهرين ونصف', 'question_text_ar' => 'يبتسم'],

            // من 4 شهور إلى 5 شهور ونصف
            ['age_range' => 'من 4 شهور إلى 5 شهور ونصف', 'question_text_ar' => 'يرفع رأسه وصدره مرتكزاً على ساعديه'],
            ['age_range' => 'من 4 شهور إلى 5 شهور ونصف', 'question_text_ar' => 'يمسك بالشخشخيخة لعدة لحظات'],
            ['age_range' => 'من 4 شهور إلى 5 شهور ونصف', 'question_text_ar' => 'يلتفت عند سماع صوت أمه'],
            ['age_range' => 'من 4 شهور إلى 5 شهور ونصف', 'question_text_ar' => 'يستجيب بسعادة عند ملاطفته'],

            // من 6 إلى 8 شهور
            ['age_range' => 'من 6 إلى 8 شهور', 'question_text_ar' => 'يجلس مسنوداً - يرفع رأسه ويمدد متكئاً على كفوف يده'],
            ['age_range' => 'من 6 إلى 8 شهور', 'question_text_ar' => 'يمسك المكعب بكل من راحة يده وأصابعه الخمسة'],
            ['age_range' => 'من 6 إلى 8 شهور', 'question_text_ar' => 'يلتفت تجاه مصدر الصوت بكل رأسه'],
            ['age_range' => 'من 6 إلى 8 شهور', 'question_text_ar' => 'يضحك لأمه ويخاف من الغرباء'],

            // من 9 إلى 12 شهر
            ['age_range' => 'من 9 إلى 12 شهر', 'question_text_ar' => 'يحبو'],
            ['age_range' => 'من 9 إلى 12 شهر', 'question_text_ar' => 'ينقل الأشياء من يد لأخرى ويشير لأشياء دقيقة بالسبابة'],
            ['age_range' => 'من 9 إلى 12 شهر', 'question_text_ar' => 'يقول ماما - بابا'],
            ['age_range' => 'من 9 إلى 12 شهر', 'question_text_ar' => 'يشير بحركة باي باي'],

            // من 12 إلى 15 شهر
            ['age_range' => 'من 12 إلى 15 شهر', 'question_text_ar' => 'يمشي حول الأثاث'],
            ['age_range' => 'من 12 إلى 15 شهر', 'question_text_ar' => 'يمسك مكعب في كل يد'],
            ['age_range' => 'من 12 إلى 15 شهر', 'question_text_ar' => 'يتكلم من 2 إلى 4 كلمات'],
            ['age_range' => 'من 12 إلى 15 شهر', 'question_text_ar' => 'يبدأ في التقليد ويعطي أمه لعبه عندما تطلبها'],

            // من 18 إلى 21 شهر
            ['age_range' => 'من 18 إلى 21 شهر', 'question_text_ar' => 'يمشي وحده ويصعد السلالم حبواً'],
            ['age_range' => 'من 18 إلى 21 شهر', 'question_text_ar' => 'يشخبط بالقلم على الورق - يبني برج من 3 مكعبات'],
            ['age_range' => 'من 18 إلى 21 شهر', 'question_text_ar' => 'يتكلم من 10 إلى 15 كلمة'],
            ['age_range' => 'من 18 إلى 21 شهر', 'question_text_ar' => 'يأكل بمفرده باستخدام الملعقة - يستخدم الكوب - يشير لأجزاء جسمه المختلفة'],

            // من 24 إلى 30 شهر
            ['age_range' => 'من 24 إلى 30 شهر', 'question_text_ar' => 'يصعد وينزل السلالم معتمداً على الحائط بجري'],
            ['age_range' => 'من 24 إلى 30 شهر', 'question_text_ar' => 'يقلد الخط المستقيم - يبني برج من 6 مكعبات'],
            ['age_range' => 'من 24 إلى 30 شهر', 'question_text_ar' => 'يقول جملة من كلمتين'],
            ['age_range' => 'من 24 إلى 30 شهر', 'question_text_ar' => 'يستخدم الملعقة جيداً - يستجيب لبعض الأوامر البسيطة'],

            // من 36 إلى 42 شهر
            ['age_range' => 'من 36 إلى 42 شهر', 'question_text_ar' => 'يقود دراجة ثلاثية عجلات - يمشي على خط مستقيم'],
            ['age_range' => 'من 36 إلى 42 شهر', 'question_text_ar' => 'يقلد رسم دائرة عندما ترسم أمامه - يبني برج من 8 إلى 9 مكعبات'],
            ['age_range' => 'من 36 إلى 42 شهر', 'question_text_ar' => 'يقول جملة من 3 كلمات - يسأل في "ليه"'],
            ['age_range' => 'من 36 إلى 42 شهر', 'question_text_ar' => 'يعرف اسمه وسنه ونوعه - يتحكم في البول أثناء النهار والليل'],

            // من 48 إلى 60 شهر
            ['age_range' => 'من 48 إلى 60 شهر', 'question_text_ar' => 'يدرك السلالم بقدم تلو الأخرى'],
            ['age_range' => 'من 48 إلى 60 شهر', 'question_text_ar' => 'يرسم مربع - يستخدم المقص'],
            ['age_range' => 'من 48 إلى 60 شهر', 'question_text_ar' => 'يقول جملة من 4 كلمات'],
            ['age_range' => 'من 48 إلى 60 شهر', 'question_text_ar' => 'يذهب للحمام وحده'],

            // من 60 إلى 72 شهر
            ['age_range' => 'من 60 إلى 72 شهر', 'question_text_ar' => 'يستطيع أن يقف على قدم واحدة - ينط الحبل'],
            ['age_range' => 'من 60 إلى 72 شهر', 'question_text_ar' => 'يستخدم فرشاة الأسنان - يستطيع ربط أزرار قميصه'],
            ['age_range' => 'من 60 إلى 72 شهر', 'question_text_ar' => 'يتحدث بطلاقة - يمكنه التعرف على عكس بعض الكلمات (كبير وعكسها صغير)'],
            ['age_range' => 'من 60 إلى 72 شهر', 'question_text_ar' => 'يلبس الحذاء لوحده - يرسم شخص'],
        ];

        foreach ($milestones as $milestone) {
            DB::table('developmental_milestone_lookups')->insert([
                'age_range' => $milestone['age_range'],
                'question_text_ar' => $milestone['question_text_ar'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}