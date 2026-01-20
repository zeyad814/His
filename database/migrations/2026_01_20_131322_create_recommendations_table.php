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
        Schema::create('recommendations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groom_id')->constrained()->cascadeOnDelete();
            $table->text('general_health_recs')->nullable(); // توصيات صحية عامة
            $table->text('genetic_recs')->nullable(); // توصيات وراثية
            $table->text('specialist_referral')->nullable(); // إحالة لطبيب متخصص
            $table->text('additional_tests_required')->nullable(); // فحوصات إضافية مطلوبة

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('recommendations');
    }
};
