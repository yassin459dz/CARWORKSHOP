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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('WORKSHOP')->nullable();
            $table->string('ADDRESS')->nullable();
            $table->string('PHONE', 10)->nullable();
            $table->string('PHONE2', 10)->nullable();
            $table->string('PHONE3', 10)->nullable();
            $table->string('FOOTER')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
