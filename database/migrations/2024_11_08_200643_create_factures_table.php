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
        Schema::create('factures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('clients')->cascadeOnDelete();//
            $table->foreignId('car_id')->constrained('cars')->cascadeOnDelete();//
            $table->foreignId('matricule_id')->constrained('matricules')->cascadeOnDelete();//
            $table->unsignedInteger('km')->nullable();
            $table->string('remark')->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->decimal('extra_charge', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->json('order_items')->nullable(); // Store order items
            $table->decimal('paid_value', 10, 2)->nullable();
            $table->enum('status', ['PAID', 'NOT PAID'])->default('PAID');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
