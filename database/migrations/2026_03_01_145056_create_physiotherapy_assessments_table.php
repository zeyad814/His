<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('physiotherapy_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained('family_members')->onDelete('cascade'); // ربط السجل بفرد العائلة (المريض)
            $table->foreignId('doctor_id')->constrained('doctors')->onDelete('cascade');
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade'); // ربط السجل بالزيارة الحالية

            // 1. البيانات الشخصية (Personal history)
            $table->date('assessment_date'); // تاريخ إجراء التقييم
            $table->string('case_type'); // نوع الحالة (مجاني، اقتصادي، تأمين صحي، نفقة دولة)
            $table->string('occupation')->nullable(); // مهنة المريض (لتحديد علاقة الإصابة بالعمل)
            $table->string('referral_source')->nullable(); // جهة التحويل (الطبيب أو المستشفى المحول للحالة)

            // 2. التاريخ المرضي (Past history)
            $table->text('medical_history_notes')->nullable(); // ملاحظات عن (إصابات، حوادث، جراحات، أدوية سابقة)
            $table->boolean('has_diabetes')->default(false); // هل يعاني من السكر؟
            $table->boolean('has_hypertension')->default(false); // هل يعاني من الضغط المرتفع؟
            $table->boolean('has_cardiac_disorder')->default(false); // هل توجد مشاكل في القلب؟
            $table->boolean('has_renal_disorder')->default(false); // هل توجد مشاكل في الكلى؟
            $table->boolean('has_hepatic_disorder')->default(false); // هل توجد مشاكل في الكبد؟

            // 3. التاريخ الحالي/الأعراض (Present history)
            $table->text('chief_complaint'); // الشكوى الرئيسية (السبب الأساسي للزيارة)
            $table->string('present_since')->nullable(); // تاريخ بداية ظهور الأعراض الحالية
            $table->enum('onset', ['acute', 'gradual'])->nullable(); // طبيعة بداية الألم (حاد Acute / تدريجي Gradual)
            $table->enum('course', ['progressive', 'regressive', 'intermittent'])->nullable(); // مسار الحالة (مستمر، متقطع، بيتحسن، بيسؤ)
            $table->boolean('is_remittent')->default(false); // هل الألم متقطع (يختفي ويعود)؟
            $table->string('pain_duration')->nullable(); // مدة استمرار نوبة الألم
            $table->enum('pain_status', ['worsening', 'unchanging', 'improving'])->nullable(); // حالة الألم الحالية (بيزيد، ثابت، بيتحسن)

            // 4. الفحوصات (Investigations)
            $table->boolean('inv_x_ray')->default(false);  // أشعة سينية (X Ray)
            $table->boolean('inv_ct')->default(false);     // أشعة مقطعية (CT)
            $table->boolean('inv_mri')->default(false);    // رنين مغناطيسي (MRI)
            $table->boolean('inv_emg')->default(false);    // رسم عصب وعضلات (EMG)
            $table->boolean('inv_lab')->default(false);    // تحاليل مخبرية (Lab)

            $table->text('investigation_details')->nullable(); // تفاصيل نتائج الفحوصات المكتوبة

            // 5. الفحص العام (General Examination)
            $table->text('gait_assessment')->nullable(); // تقييم طريقة المشي (وجود عرج أو عدم اتزان)
            $table->text('manual_muscle_test')->nullable(); // نتائج اختبار قوة العضلات يدوياً
            $table->text('special_tests')->nullable(); // نتائج الاختبارات الخاصة (مثل اختبارات الأربطة والظهر)
            $table->text('neurological_examination')->nullable(); // نتائج الفحص العصبي (الإحساس وردود الفعل)
            // $table->string('body_chart_image')->nullable(); // مسار صورة الرسم التوضيحي لتحديد أماكن الألم

            // 6. التشخيص (Diagnosis)
            $table->text('diagnosis'); // التشخيص النهائي الذي وضعه أخصائي العلاج الطبيعي

            // 7. قائمة المشاكل والأهداف (Goals)
            $table->boolean('goal_relief_pain')->default(false);      // تقليل الألم والالتهاب (Relief pain & inflammation)
            $table->boolean('goal_reduce_swelling')->default(false);  // تقليل التورم (Reduce swelling)
            $table->boolean('goal_improve_rom')->default(false);      // تحسين مدى حركة المفاصل (Improve joint ROM)
            $table->boolean('goal_improve_strength')->default(false); // تحسين قوة العضلات (Improve muscle strength)
            $table->boolean('goal_improve_gait')->default(false);     // تحسين المشي والتوازن (Improve gait and balance)
            $table->text('other_goals')->nullable();                 // أهداف أخرى (لو الطبيب عايز يكتب هدف يدوي)

            // 8. البرنامج العلاجي (Treatment plan)
            $table->boolean('modality_us')->default(false);      // موجات فوق صوتية (US)
            $table->boolean('modality_ir')->default(false);      // أشعة تحت حمراء (IR)
            $table->boolean('modality_tens')->default(false);    // تيارات لتسكين الألم (TENS)
            $table->boolean('modality_faradic')->default(false); // تيارات لتنبيه العضلات (Faradic)
            $table->boolean('modality_laser')->default(false);   // ليزر علاجي (Laser)

            $table->text('manual_therapy_exercises')->nullable(); // تفاصيل العلاج اليدوي والتمارين العلاجية المطلوبة
            $table->string('follow_up_schedule')->nullable(); // جدول مواعيد المتابعة المتفق عليها
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physiotherapy_assessments');
    }
};
