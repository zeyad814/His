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
        Schema::create('child_milestone_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');
            $table->foreignId('visit_id')->constrained('visits')->onDelete('cascade');
            $table->foreignId('milestone_lookup_id')->constrained("developmental_milestone_lookups")->onDelete('cascade');
            $table->boolean('is_achieved'); 
            // $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('child_milestone_results');
    }
};
