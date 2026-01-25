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
            $table->enum('income_type', ['fixed', 'variable'])->nullable(); 
            $table->decimal('avg_income', 12, 2)->nullable();
            $table->boolean('has_chronic_diseases')->default(false);
            $table->boolean('has_disability')->default(false);
            $table->boolean('receives_pension')->default(false);
            $table->boolean('eligible_for_free_service')->default(false);
            $table->string('supporter_name_on_death')->nullable();
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
