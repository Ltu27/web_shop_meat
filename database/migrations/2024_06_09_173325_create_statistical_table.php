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
        Schema::create('statistical', function (Blueprint $table) {
            $table->id();
            $table->string('order_date', 100);
            $table->string('sales', 200);
            $table->string('profit', 200);
            $table->integer('quantity');
            $table->integer('total_order');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('statistical');
    }
};
