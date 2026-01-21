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
        Schema::create('emergency_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nurse_id')->constrained()->cascadeOnDelete();
            $table->dateTime('arrival_time'); // وقت الوصول للطوارئ  
            $table->string('chief_complaint')->nullable(); // الشكوى الرئيسية
            $table->enum('triage_level', ['1', '2', '3', '4', '5'])->nullable();
            // مستوى الفرز الطبي (Triage Level)
            $table->dateTime('triage_time')->nullable(); // وقت إجراء الفرز الطبي
            $table->dateTime('exit_time')->nullable(); // وقت الخروج من الطوارئ
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emergency_forms');
    }
};
