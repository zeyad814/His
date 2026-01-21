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
        Schema::create('radiology_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('radiological_request_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete(); // الطبيب الذي كتب تقرير الأشعة
            $table->text('findings_text')->nullable(); // نتائج الأشعة / وصف الملاحظات
            $table->string('radiation_dose', 50)->nullable(); // جرعة الإشعاع
            $table->dateTime('report_date_time'); // تاريخ ووقت كتابة التقرير
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('radiology_reports');
    }
};
