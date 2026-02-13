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
        Schema::create('postnatal_cares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pregnancy_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->date('visit_date');

            //Delivery outcome ناتج الحمل الحالي
            $table->enum('delivery_type', ['natural', 'cesarean'])->nullable();
            $table->date('delivery_date')->nullable();
            $table->enum('baby_status', ['alive', 'dead', 'abortion'])->nullable();
            $table->string('delivery_place')->nullable();
            $table->string('attended_by')->nullable();   // القائم بالولادة
            $table->text('delivery_complications')->nullable(); // مضاعفات الولادة

            //Postpartum visits زيارات النفاس
            //first visit
            $table->date('first_pnc_visit_date')->nullable();
            $table->string('first_pnc_visit_result')->nullable();

            //second visit
            $table->date('second_pnc_visit_date')->nullable();
            $table->string('second_pnc_visit_result')->nullable();

            //third visit
            $table->date('third_pnc_visit_date')->nullable();
            $table->string('third_pnc_visit_result')->nullable();

            //Clinical assessment التقييم الإكلينيكي
            $table->string('breastfeeding_type')->nullable(); // نوع الرضاعة
            $table->string('breastfeeding_assessment')->nullable(); // تقييم الوضعية
            $table->text('breastfeeding_problems')->nullable();

            $table->string('depression_screening')->nullable(); // فحص الاكتئاب
            $table->string('social_adjustment')->nullable(); // التكيف الاجتماعي
            $table->text('maternal_concerns')->nullable(); // مخاوف الأم

            $table->text('health_education')->nullable(); // التثقيف الصحي

            //Contraception تنظيم الأسره
            $table->string('contraception_method')->nullable();
            $table->date('contraception_date')->nullable();

            $table->text('additional_notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postnatal_cares');
    }
};
