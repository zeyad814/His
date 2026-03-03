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
        Schema::create('premarital_screenings', function (Blueprint $table) {
            $table->id();
            // الربط الأساسي
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['groom', 'bride']); // تحديد النوع (خاطب / مخطوبة)
            
            // 1. التاريخ الطبي (Medical History)
            $table->boolean('consanguinity')->default(false); // صلة القرابة
            $table->text('hereditary_diseases')->nullable(); // الأمراض الوراثية بالعائلة
            $table->text('infectious_diseases')->nullable(); // الأمراض المعدية الحالية
            $table->text('chronic_diseases')->nullable();    // الأمراض المزمنة
            $table->text('previous_surgeries')->nullable(); // عمليات جراحية سابقة
            
            // 2. الفحص الإكلينيكي (Clinical Examination)
            $table->string('blood_pressure')->nullable();   // ضغط الدم
            $table->integer('pulse')->nullable();            // النبض
            $table->decimal('weight', 5, 2)->nullable();     // الوزن
            $table->decimal('height', 5, 2)->nullable();     // الطول
            $table->decimal('bmi', 4, 2)->nullable();        // مؤشر كتلة الجسم
            $table->text('general_look')->nullable();       // المظهر العام
            
            // 3. النتائج المعملية (Lab Results)
            $table->string('blood_group_rh')->nullable();   // فصيلة الدم و Rh
            $table->string('hemoglobin_level')->nullable(); // نسبة الهيموجلوبين
            $table->string('blood_sugar')->nullable();      // سكر الدم
            $table->string('hbsag_result')->nullable();     // فيروس بي
            $table->string('hiv_result')->nullable();       // فيروس نقص المناعة
            
            // 4. الإقرارات والقرار (Decision & Consent)
            $table->text('medical_recommendation')->nullable(); // التوصية الطبية
            $table->boolean('is_referred_to_specialist')->default(false); // هل تم التحويل لأخصائي؟
            $table->boolean('patient_informed')->default(false); // إقرار بعلم الطرفين بالنتائج
            $table->timestamp('examination_date');
            
            $table->softDeletes(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premarital_screenings');
    }
};
