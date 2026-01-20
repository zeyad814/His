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
        Schema::create('grooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->cascadeOnDelete(); 
            $table->unsignedInteger('age'); 
            $table->boolean('is_male');
            $table->string('address')->nullable(); 
            $table->date('date_of_examination')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grooms');
    }
};
