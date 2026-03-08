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
        Schema::create('critical_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->nullable()->constrained('family_members')->onDelete('set null');
            // المعنى: معرّف أحد أفراد العائلة (في حالة تعذر الوصول للمريض أو حاجته لمرافق)
            // السبب: قانونياً وطبياً، لازم نوثق لو بلّغنا حد من الأهل بالنتيجة الحرجة.
            
            $table->foreignId('visit_id')->constrained('visits') ->onDelete('cascade');
            // المعنى: معرّف الزيارة الحالية للمريض (Inpatient أو Outpatient)
            // السبب: عشان نعرف النتيجة دي تبع أنهي دخول للمستشفى (Admission).
            
            $table->string('test_type_and_value'); 
            // المعنى: نوع الفحص والنتيجة الحرجة. 
            // السبب: نصي لأنه بيشمل اسم التحليل وقيمته (مثلاً: Glucose 450 mg/dL).

            $table->dateTime('result_generated_at'); 
            // المعنى: وقت ظهور النتيجة من الجهاز/المعمل.
            // السبب: DateTime لتوثيق اللحظة الصفرية لبدء الحالة الحرجة.

            // --- بيانات الإبلاغ (التواصل) ---
            $table->dateTime('notified_at')->nullable(); 
            // المعنى: وقت إبلاغ الطبيب الفعلي.
            // السبب: لمقارنته بوقت الظهور وقياس سرعة الاستجابة (TAT).

            $table->string('notification_method')->default('system_alert'); 
            // المعنى: وسيلة الإبلاغ.
            // السبب: بنخلي القيمة الافتراضية "إشعار نظام" وزي ما اتفقنا ممكن تتعدل لـ (تليفون/مقابلة).

            $table->string('receiving_clinic'); 
            // المعنى: القسم أو العيادة المستلمة للبلاغ (رعاية، طوارئ..).

            $table->foreignId('notifier_id')->constrained('doctors') ->onDelete('cascade');
            // المعنى: اسم الشخص اللي بلغ (دكتور المعمل/الأشعة).

            $table->foreignId('recipient_id')->nullable()->constrained('doctors')->onDelete('set null');
            // المعنى: اسم الشخص اللي استقبل البلاغ في القسم الطبي.
            // السبب: Nullable لأن وقت الإشعار الآلي لسه مكنش فيه "شخص" استلم.

            // --- قرار الطبيب ---
            $table->boolean('is_accepted')->nullable()->default(null); 
            // المعنى: قبول أو رفض النتيجة.
            // السبب: Boolean (True للقبول، False للرفض) لسهولة الفلترة في التقارير.

            $table->text('doctor_action')->nullable(); 
            // المعنى: الإجراء الطبي المتخذ (مثلاً: إعطاء أنسولين).
            // السبب: Text عشان الطبيب يكتب وصف براحته.

            // --- مسار الرفض والنتيجة الثانية (تُملأ فقط عند الرفض) ---
            $table->string('second_result_value')->nullable(); 
            // المعنى: قيمة النتيجة التانية التأكيدية.

            $table->dateTime('second_result_generated_at')->nullable(); 
            // المعنى: وقت ظهور النتيجة التانية.

            $table->dateTime('second_notified_at')->nullable(); 
            // المعنى: وقت إبلاغ النتيجة التانية.

            $table->foreignId('second_notifier_id')->nullable()->constrained('doctors')->onDelete('set null');
            $table->foreignId('second_recipient_id')->nullable()->constrained('doctors')->onDelete('set null');

            $table->text('reporting_difficulties')->nullable(); 
            // المعنى: الصعوبات اللي واجهت المبلغ (تأخير رد، تليفون مشغول).
            // السبب: مهم جداً للجودة لتبرير أي تأخير في الـ TAT.

            // --- الاعتماد النهائي ---
            $table->foreignId('doctor_id')->nullable()->constrained('doctors')->onDelete('set null');
            // المعنى: توقيع الطبيب. 
            // السبب: لو نظام إلكتروني بنخزن اسم الدكتور أو مسار صورة توقيعه (Path).
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('critical_results');
    }
};
