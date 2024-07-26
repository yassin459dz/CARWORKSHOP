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
        Schema::create('devis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();
            $table->foreignId('cars_id')->constrained('clients')->cascadeOnDelete();
            $table->unsignedInteger('DEVI_NUMBER')->unique();
            $table->unsignedBigInteger('KM');
            $table->string('PRODUCT');
            $table->decimal('PRICE', 10, 2);
            $table->integer('QTE');
            $table->decimal('TOTAL', 10, 2);
            $table->string('REMARK')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devis');
    }
};
