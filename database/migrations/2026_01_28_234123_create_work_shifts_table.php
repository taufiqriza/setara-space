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
        Schema::create('work_shifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->timestamp('start_time');
            $table->timestamp('end_time')->nullable();
            
            $table->decimal('start_cash', 15, 2)->default(0);
            $table->decimal('end_cash_expected', 15, 2)->nullable();
            $table->decimal('end_cash_actual', 15, 2)->nullable();
            
            $table->string('start_photo')->nullable();
            $table->string('end_photo')->nullable();
            
            $table->string('status')->default('open'); // open, closed
            $table->text('note')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('work_shifts');
    }
};
