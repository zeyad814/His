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
        Schema::create('birth_screenings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade'); // ربط بجدول الطفل

            // أثناء الحمل والولادة
            $table->boolean('has_danger_signs')->default(false); // وجود علامات خطر
            $table->text('danger_signs_details')->nullable(); // تفاصيل علامات الخطر
            $table->string('delivery_type')->nullable(); // نوع الولادة (طبيعي/قيصري)
            $table->string('delivery_place')->nullable(); // مكان الولادة
            $table->string('delivered_by')->nullable(); // القائم بالولادة

            // الحضانة والرضاعة
            $table->boolean('incubator_entry')->default(false); // دخول حضانة
            $table->text('incubator_reason_duration')->nullable(); // سبب ومدة الحضانة
            $table->string('breastfeeding_start')->nullable(); // بدء الرضاعة الطبيعية

            // الصفراء
            $table->boolean('has_jaundice')->default(false); // حدوث صفراء
            $table->date('jaundice_date')->nullable(); // تاريخ حدوث الصفراء
            $table->text('jaundice_action_treatment')->nullable(); // التصرف / العلاج

            // مسح حديثي الولادة (الغدة الدرقية)
            $table->date('first_sample_date')->nullable(); // تاريخ العينة الأولى
            $table->string('first_sample_result')->nullable(); // نتيجة العينة الأولى
            $table->date('repeated_sample_date')->nullable(); // تاريخ العينة المكررة
            $table->string('repeated_sample_result')->nullable(); // نتيجة العينة المكررة
            $table->date('venous_sample_date')->nullable(); // تاريخ الوريدية
            $table->string('final_screening_result')->nullable(); // النتيجة النهائية
            $table->text('final_diagnosis')->nullable(); // التشخيص النهائي

            // فحوصات وفيتامينات إضافية
            $table->string('oae_test_result')->nullable(); // اختبار الانبعاث الصوتي
            $table->enum('vitamin_a_dose', ['9_months', '18_months'])->nullable();

            // حالات خاصة (Special Cases)
            $table->boolean('sensory_defects')->default(false)->nullable(); // عيوب حواس (سمع/بصر)
            $table->boolean('speech_difficulties')->default(false)->nullable(); // صعوبات تعلم/كلام
            $table->boolean('growth_retardation')->default(false)->nullable(); // تأخر نمو عقلي
            $table->boolean('autism')->default(false)->nullable(); // توحد (أوتيزم)
            $table->boolean('genetic_diseases')->default(false)->nullable(); // أمراض وراثية
            $table->boolean('allergies')->default(false)->nullable(); // حساسية
            $table->text('other_special_cases')->nullable(); // أخرى (تذكر)
            $table->text('special_cases_medications')->nullable(); // أدوية / أغذية خاصة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('birth_screenings');
    }
};
