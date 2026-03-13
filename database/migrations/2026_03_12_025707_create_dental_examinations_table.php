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
            $table->foreignId('family_member_id')->unique()->constrained()->cascadeOnDelete(); // ربط الفحص بمريض معين
            $table->foreignId('doctor_id')->constrained()->cascadeOnDelete();

            // 1. General Information
            $table->string('occupation')->nullable(); 
            // النوع: String | الغرض: تخزين مهنة المريض | يستقبل: نص حر (مثل: مهندس، طالب)

            $table->tinyInteger('location_type'); 
            // النوع: Integer | الغرض: تصنيف مكان السكن | يستقبل: (1 للـ Urban، 2 للـ Rural)

            // 2. Clinical Assessment (Extra-Oral)
            $table->tinyInteger('extra_oral_exam')->default(0); 
            // النوع: Integer | الغرض: كود الحالة الظاهرية | يستقبل: أرقام (0-9) حسب الجدول

            $table->tinyInteger('tmj_symptom')->default(9); 
            // النوع: Integer | الغرض: أعراض مفصل الفك | يستقبل: (0: No, 1: Yes, 9: Not recorded)

            $table->tinyInteger('tmj_signs')->default(9); 
            // النوع: Integer | الغرض: علامات مفصل الفك | يستقبل: (0: No, 1: Yes, 9: Not recorded)

            $table->boolean('tmj_clicking')->default(false); 
            // النوع: Boolean | الغرض: صوت طقطقة | يستقبل: (true/false) أو (1/0)

            $table->boolean('tmj_tenderness')->default(false); 
            // النوع: Boolean | الغرض: وجود ألم عند اللمس | يستقبل: (true/false)

            $table->boolean('tmj_reduced_mobility')->default(false); 
            // النوع: Boolean | الغرض: قلة حركة الفك | يستقبل: (true/false)

            // 3. Oral Mucosa & Indices
            $table->tinyInteger('mucosa_condition')->default(0); 
            // النوع: Integer | الغرض: حالة غشاء الفم | يستقبل: أكواد (0-9)

            $table->tinyInteger('mucosa_location')->default(0); 
            // النوع: Integer | الغرض: مكان الإصابة | يستقبل: أكواد (0-9)

            $table->string('mucosa_other')->nullable(); 
            // النوع: String | الغرض: وصف حالات أخرى | يستقبل: نص (لو اختار كود 8)

            $table->json('cpi_sections'); 
            // النوع: JSON Array | الغرض: تخزين 6 قيم لمؤشر اللثة | يستقبل: مصفوفة أرقام [0,1,2,X...]

            $table->tinyInteger('fluorosis_index')->default(9); 
            // النوع: Integer | الغرض: مؤشر تفلور الأسنان | يستقبل: أكواد (0-9)

            $table->tinyInteger('trauma_index')->default(0); 
            // النوع: Integer | الغرض: مؤشر إصابات الأسنان | يستقبل: أكواد (0-5)

            // 4. Other Findings
            $table->text('white_spot_lesions')->nullable(); 
            // النوع: Text | الغرض: وصف بقع بيضاء | يستقبل: نص طويل (Paragraph)

            $table->text('enamel_defects')->nullable(); 
            // النوع: Text | الغرض: عيوب المينا | يستقبل: نص طويل

            $table->text('developmental_anomalies')->nullable(); 
            // النوع: Text | الغرض: عيوب خلقية | يستقبل: نص طويل

            $table->text('clefts')->nullable(); 
            // النوع: Text | الغرض: وجود شقوق (Clefts) | يستقبل: نص طويل

            $table->tinyInteger('occlusion_class')->nullable(); 
            // النوع: Integer | الغرض: درجة إطباق الفكين | يستقبل: (1, 2, 3, 4)

            $table->tinyInteger('primary_mesial_step')->nullable(); 
            // النوع: Integer | الغرض: حالة الأسنان اللبنية | يستقبل: (1, 2, 3)
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
