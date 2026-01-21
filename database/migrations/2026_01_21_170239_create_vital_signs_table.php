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
        Schema::create('vital_signs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('emergency_form_id')->constrained()->cascadeOnDelete();
            $table->integer('pulse')->nullable(); // النبض
            $table->integer('bp_systolic')->nullable(); // ضغط الدم الانقباضي
            $table->decimal('temperature', 4, 1)->nullable(); // درجة الحرارة
            $table->integer('attribute')->nullable(); // غير واضح طبيًا - موجود حسب ERD
            $table->integer('respiratory_rate')->nullable(); // معدل التنفس
            $table->string('consciousness_level')->nullable();
            // مستوى الوعي (Alert, Verbal, Pain, Unresponsive)
            $table->integer('oxygen_saturation')->nullable(); // تشبع الأكسجين %
            $table->integer('blood_sugar')->nullable();  // سكر الدم
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vital_signs');
    }
};
