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
        Schema::create('verbal_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('family_member_id')->constrained()->onDelete('cascade');            
            $table->text('instructions');
            $table->dateTime('order_date_time');
            $table->foreignId('ordered_by_doctor_id')->constrained("doctors")->onDelete('cascade'); 
            $table->foreignId('recorded_by_nurse_id')->nullable()->constrained("nurses")->nullOnDelete(); 
            $table->boolean('is_confirmed')->default(false);

            $table->foreignId('confirmed_by_doctor_id')->nullable()->constrained('doctors')->onDelete('cascade');                  
            $table->dateTime('confirmation_date_time')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('verbal_orders');
    }
};
