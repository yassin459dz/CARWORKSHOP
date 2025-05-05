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
        Schema::create('cashboxes', function (Blueprint $table) {
            $table->id();
            $table->decimal('start_value', 15, 2);                 // forced (nullable = false)
            $table->decimal('end_value', 15, 2)->nullable();       // editable by boss
            $table->decimal('manual_end_value', 15, 2)->nullable();
            $table->boolean('manual_end_set')->default(false)->after('manual_end_value');
            $table->decimal('decalage', 15, 2)->nullable();
            $table->decimal('next_start_value', 15, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashboxes');
    }
};
