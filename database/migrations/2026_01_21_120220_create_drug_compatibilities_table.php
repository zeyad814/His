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
        Schema::create('drug_compatibilities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pharmacy_id')->constrained()->cascadeOnDelete(); 
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->date('visit_date');
            $table->text('current_home_meds')->nullable(); // الأدوية الحالية التي يتناولها المريض
            $table->text('recommended_meds')->nullable(); // الأدوية المقترحة
            $table->boolean('has_pharmacist_recommendation')->default(false); // هل توجد توصية من الصيدلي؟
            $table->text('pharmacist_recommendation_text')->nullable(); // نص توصية الصيدلي
            $table->text('doctor_response')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drug_compatibilities');
    }
};
