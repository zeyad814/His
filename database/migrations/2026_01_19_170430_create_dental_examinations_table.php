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
        Schema::create('dental_examinations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained() ->cascadeOnDelete();
            $table->string('location_type')->nullable(); // نوع السكن
            $table->string('occupation')->nullable(); // المهنة

            $table->string('dental_trauma_index')->nullable(); // مؤشر إصابات الأسنان
            $table->string('permanent_teeth_status')->nullable(); // حالة الأسنان الدائمة
            $table->string('primary_teeth_status')->nullable(); // حالة الأسنان اللبنية
            $table->string('primary_dentition_step')->nullable(); // مرحلة الأسنان اللبنية
            $table->string('cpi_code')->nullable(); // كود صحة اللثة
            $table->string('dental_fluorosis')->nullable(); // فلوروز الأسنان
            $table->string('extra_oral_code')->nullable(); // كود الفحص الخارجي
            $table->string('white_spot_lesions')->nullable(); // بقع بيضاء
            $table->string('tmj_clicking')->nullable();  // طقطقة المفصل
            $table->string('tmj_tenderness')->nullable(); // ألم المفصل
            $table->string('tmj_reduced_mobility')->nullable(); // محدودية حركة المفصل
            $table->string('enamel_defects')->nullable(); // عيوب المينا
            $table->string('tooth_development_anomalies')->nullable(); // تشوهات نمو الأسنان
            $table->string('clefts')->nullable(); // شقوق خلقية
            $table->string('oral_mucosa_condition')->nullable(); // حالة الغشاء المخاطي
            $table->string('oral_mucosa_location')->nullable(); // مكان الإصابة
            $table->string('occlusion')->nullable(); // الإطباق
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dental_examinations');
    }
};
