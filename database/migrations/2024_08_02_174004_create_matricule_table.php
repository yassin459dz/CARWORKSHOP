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
        Schema::create('matricules', function (Blueprint $table) {
            $table->id(); // default is unsignedBigInteger
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
            $table->foreignId('car_id')->nullable()->constrained('cars')->cascadeOnDelete();
            $table->string('mat');
            $table->unsignedInteger('km')->nullable();
            $table->string('anne')->nullable();
            $table->string('work')->nullable();
            $table->string('remark')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matricules');
    }
};
