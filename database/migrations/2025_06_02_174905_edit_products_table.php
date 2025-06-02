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
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('image', 100)->nullable()->change();
            $table->float('sale_price', 10,2)->nullable()->change();
            $table->float('price', 10,2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable(false);
            $table->string('image', 100)->nullable(false);
            $table->float('sale_price', 10,2)->nullable(false)->change();
            $table->float('price', 10,2)->nullable(false)->change();
        });
    }
};
