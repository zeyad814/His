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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groom_id')->constrained()->cascadeOnDelete();
            $table->boolean('consanguinity')->nullable(); // صلة قرابة
            $table->text('infectious_diseases')->nullable(); // أمراض معدية
            $table->text('hereditary_diseases')->nullable(); // أمراض وراثية
            $table->text('chronic_diseases')->nullable(); // أمراض مزمنة
            $table->text('family_hereditary_history')->nullable(); // تاريخ وراثي عائلي
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
