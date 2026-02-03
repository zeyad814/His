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
        Schema::create('growth_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('birth_screening_id')->constrained('birth_screenings')->onDelete('cascade');
            $table->foreignId('visit_id')->constrained()->onDelete('cascade');

            $table->date('visit_date'); // التاريخ
            $table->string('age_stage'); // العمر (عند الولادة، شهر، شهرين...)

            $table->decimal('weight_kg', 5, 2)->nullable(); // الوزن (كجم)
            $table->decimal('height_cm', 5, 2)->nullable(); // الطول (سم)
            $table->decimal('head_circumference_cm', 5, 2)->nullable(); // محيط الرأس (سم)

            $table->boolean('use_pacifier')->default(false); // استخدام لهاية
            $table->boolean('exclusive_breastfeeding')->default(false); // نوع الرضاعة (مطلقة)
            $table->boolean('supplementary_feeding')->default(false); // نوع الرضاعة (مكملات)
            $table->boolean('bottle_feeding')->default(false); // نوع الرضاعة (بزونة)
            $table->boolean('cup_spoon_feeding')->default(false); // نوع الرضاعة (كوب وملعقة)
            $table->boolean('natural_breastfeeding')->default(false)->nullable(); // رضاعة طبيعية
            $table->text('other_foods')->nullable(); // أغذية أخرى

            $table->decimal('hemoglobin_level', 4, 2)->nullable(); // الهيموجلوبين
            $table->boolean('mandatory_vaccinations')->default(false); // التطعيمات الإجبارية
            $table->text('other_vaccinations')->nullable(); // تطعيمات أخرى
            $table->date('vaccination_date')->nullable(); // تاريخ التطعيم
            // $table->foreignId('nurse_id')->nullable()->constrained('nurses')->onDelete('set null'); // توقيع الممرضة
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('growth_visits');
    }
};
