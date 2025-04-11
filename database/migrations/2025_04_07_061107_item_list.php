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
        Schema::create('item_list', function (Blueprint $table) {
            $table->id('item_list_id')->autoIncrement()->unique();
            $table->foreignId('item_id')->constrained('item', 'item_id')->onDelete('cascade');
            $table->foreignId('inventory_id')->constrained('inventory', 'inventory_id')->onDelete('cascade');
            $table->integer('quantity');
            $table->date('date_added');
            $table->string('status')->default('available'); // available, out_of_stock
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
