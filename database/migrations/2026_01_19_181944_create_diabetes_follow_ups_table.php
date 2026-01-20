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
        Schema::create('diabetes_follow_ups', function (Blueprint $table) {
            $table->id();

            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->text('workup_every_visit')->nullable();
            $table->text('health_education')->nullable();
            $table->text('chief_complaint')->nullable();
            $table->text('referrals')->nullable(); // تحويلات
            $table->text('risk_factors')->nullable();
            $table->text('treatment_plan')->nullable();
            $table->text('complications')->nullable(); // المضاعفات
            $table->text('workup_6_month')->nullable();
            $table->text('workup_annual')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diabetes_follow_ups');
    }
};
