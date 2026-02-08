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
        Schema::create('child_growth_measurements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('visit_id')->unique()->constrained()->onDelete('cascade');
            $table->integer('age_months');
            $table->decimal('head_circumference', 5, 2)->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->decimal('height', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_growth_measurements');
    }
};
