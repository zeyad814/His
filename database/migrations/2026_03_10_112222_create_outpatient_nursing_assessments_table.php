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
        Schema::create('outpatient_nursing_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nurse_id')->constrained();

            // العلامات الحيوية
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->string('blood_pressure')->nullable();
            $table->integer('pulse')->nullable();
            $table->integer('respiratory_rate')->nullable();
            $table->decimal('temperature', 4, 1)->nullable();
            $table->integer('spo2')->nullable();

            // النفسي والاجتماعي والحساسية (Boolean لسهولة الفلترة)
            $table->boolean('is_smoking')->default(false);
            $table->boolean('is_alcoholic')->default(false);
            $table->boolean('has_allergy')->default(false);
            $table->text('allergy_details')->nullable();

            // الألم
            $table->integer('pain_score')->default(0);
            $table->string('pain_location')->nullable();

            // ملخص السقوط (هنا الربط بالجدول التاني)
            $table->boolean('needs_detailed_fall_assessment')->default(false);
            $table->string('final_fall_risk_level')->nullable(); // (Low, Medium, High)

            $table->text('nursing_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('outpatient_nursing_assessments');
    }
};
