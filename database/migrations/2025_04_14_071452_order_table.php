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
        Schema::create('order_table', function (Blueprint $table) {
            $table->id('order_id')->autoIncrement()->unique();
            $table->string('customer_name');
            $table->foreignId('employee_id')->constrained('employee', 'employee_id')->onDelete('cascade');
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
