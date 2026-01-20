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
        Schema::create('families', function (Blueprint $table) {
            $table->id();

            $table->string('family_code')->unique();
            $table->char('national_id',14)->unique();
            $table->string('head_name');

            $table->string('governorate');
            $table->string('health_department');
            $table->string('village_or_city');
            $table->string('health_unit');
            $table->string('address');
            $table->string('mobile_phone')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('nearest_phone')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('families');
    }
};
