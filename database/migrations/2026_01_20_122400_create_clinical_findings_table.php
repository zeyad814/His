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
        Schema::create('clinical_findings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('groom_id')->constrained()->cascadeOnDelete();
            $table->text('vital_signs')->nullable(); // العلامات الحيوية
            $table->text('physical_measurements')->nullable(); // القياسات الجسمانية
            $table->text('body_examination')->nullable(); // الفحص الإكلينيكي

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clinical_findings');
    }
};
