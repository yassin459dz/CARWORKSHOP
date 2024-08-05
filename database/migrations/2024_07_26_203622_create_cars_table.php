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
        Schema::create('cars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->nullable()->constrained('clients')->cascadeOnDelete();
           // $table->foreignId('brand_id')->nullable()->constrained('brands')->cascadeOnDelete();
            //$table->foreignId('color_id')->nullable()->constrained('colors')->cascadeOnDelete();


            //$table->string('brand')->nullable();
            $table->string('model');
            //$table->string('color')->nullable();
            //$table->string('mat');
            //$table->unsignedBigInteger('km');
            //$table->string('remark')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars');
    }
};
