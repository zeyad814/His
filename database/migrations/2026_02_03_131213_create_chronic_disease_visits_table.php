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
        Schema::create('chronic_disease_visits', function (Blueprint $table) {
            $table->id();
            //تفاصيل الزيارةا

            $table->foreignId('chronic_disease_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->foreignId('visit_id')->constrained()->cascadeOnDelete();
            $table->text('complain')->nullable(); // الشكوى
            $table->text('exam')->nullable();
            $table->text('vital_signs')->nullable(); // العلامات الحيوية
            $table->text('investigations')->nullable();  // الفحوصات
            $table->text('management')->nullable();  // الخطة العلاجية
            $table->text('notes')->nullable();  // ملاحظات
            $table->date('visit_date'); // تاريخ الزيارة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chronic_disease_visits');
    }
};
