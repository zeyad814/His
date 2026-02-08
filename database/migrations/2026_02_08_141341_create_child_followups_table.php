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
        Schema::create('child_followups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('visit_id')->unique()->constrained()->onDelete('cascade');
            $table->string('age');
            $table->decimal('weight', 5, 2);
            $table->decimal('height', 5, 2);
            $table->boolean('vaccine_dt')->default(false);
            $table->boolean('vaccine_meningitis')->default(false);
            $table->string('other_vaccines')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_followups');
    }
};
