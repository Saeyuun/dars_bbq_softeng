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
        Schema::create('inventory_history', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('inventory_id')->nullable();
            $table->string('item_name'); // Store the item name
            $table->string('changes'); // 'added', 'updated', 'deleted'
            $table->integer('quantity_at_time')->nullable();
            $table->string('status_at_time')->nullable();
            $table->timestamps();
            $table->foreign('inventory_id')
                  ->references('inventory_id')
                  ->on('inventory')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_history');
    }
};
