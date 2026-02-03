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
        Schema::create('clinical_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('visit_id')->constrained()->onDelete('cascade');

            // بيانات الزيارة الأساسية
            $table->date('visit_date'); // التاريخ
            $table->string('age_stage'); // المرحلة العمرية (مثلاً: من الولادة لشهرين، 4 شهور...)

            // التقييم الطبي
            $table->text('clinical_assessment')->nullable(); // الفحص الإكلينيكي
            $table->text('parental_concern')->nullable(); // مخاوف الأهل / الشكوى
            $table->text('health_education')->nullable(); // التثقيف الصحي
            $table->text('notes')->nullable(); // ملاحظات أخرى

            $table->foreignId('doctor_id')->nullable()->constrained()->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_examinations');
    }
};
