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
        Schema::create('social_research', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->enum('income_level', ['low', 'medium', 'high'])->nullable();
            $table->decimal('avg_income', 10, 2)->nullable();
            $table->string('chronic_diseases')->nullable();
            $table->boolean('free_service')->default(false);
            $table->boolean('pension')->default(false);
            $table->boolean('disability')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_research');
    }
};
