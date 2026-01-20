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
        Schema::create('physical_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->text('family_history')->nullable();
            $table->text('hospitalization')->nullable(); //تاريخ الدخول للمستشفيات
            $table->text('lab_tests_results')->nullable(); //التحاليل الطبيه و نتائجها
            $table->text('special_habits')->nullable();
            $table->text('previous_operations')->nullable();
            $table->text('current_medication')->nullable();
            $table->text('trauma_injuries')->nullable();
            $table->text('allergy')->nullable();
            $table->text('adverse_drug_reaction')->nullable(); //تفاعلات عكسيه من ادويه
            $table->text('abuse_negligence')->nullable(); //إساءه أو إهمال
            $table->text('psychiatric_history') ->nullable(); //التاريخ النفسي

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('physical_examinations');
    }
};
