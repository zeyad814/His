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
        Schema::create('family_members', function (Blueprint $table) {
            $table->id();
            
            $table->string('full_name');
            $table->boolean('is_male');
            $table->date('birth_date');
            $table->enum('relationship_to_head', ['father','mother','husband','wife','son','daughter']);
            $table->enum('insurance_type', ['private', 'public', 'none'])->nullable();
            $table->text('notes')->nullable();

            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('family_members');
    }
};
