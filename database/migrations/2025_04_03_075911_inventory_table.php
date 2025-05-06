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
        Schema::create('inventory', function (Blueprint $table) {
            $table->id('inventory_id')->autoIncrement()->unique();
            $table->foreignId('employee_id')->constrained('employee', 'employee_id')->onDelete('cascade');
            // $table->foreignId('item_id')->constrained('item', 'item_id')->onDelete('cascade');
            $table->integer('quantity');
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
