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
        Schema::create('caisse_historiques', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cashbox_id')
                  ->nullable()
                  ->constrained('cashboxes')
                  ->onDelete('set null');
                  $table->decimal('montant', 15, 2)->default(0);
                  $table->string('type')->nullable(); // e.g., 'SORTIE' or 'ENTREE'
                  $table->timestamps(); // created_at = date of movement

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caisse_historiques');
    }
};
