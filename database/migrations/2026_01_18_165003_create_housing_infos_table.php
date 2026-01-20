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
        Schema::create('housing_infos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_id')->constrained()->cascadeOnDelete();
            $table->integer('rooms_count')->nullable();
            $table->integer('sleeping_rooms_specified')->nullable();
            $table->enum('ventilation', ['good', 'poor'])->nullable(); //التهويه
            $table->enum('water_source', ['public', 'non_public', 'other'])->nullable();
            $table->enum('sanitation_type', ['sanitary', 'pit'])->nullable(); //نوع الصرف الصحي
            $table->enum('lighting_type', ['electricity', 'other'])->nullable(); //نوع الاضاءه
            $table->boolean('has_animals')->nullable();
            $table->enum('barn_location', ['inside', 'outside'])->nullable(); //وجود حظيره
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('housing_infos');
    }
};
