<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->string('image', 100)->nullable()->change();
            $table->float('sale_price', 10, 2)->nullable()->change();
            $table->float('price', 10, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        DB::table('products')->whereNull('description')->update(['description' => 'Không có mô tả']);
        DB::table('products')->whereNull('image')->update(['image' => 'no-image.jpg']);
        DB::table('products')->whereNull('sale_price')->update(['sale_price' => 0]);
        DB::table('products')->whereNull('price')->update(['price' => 0]);

        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable(false)->change();
            $table->string('image', 100)->nullable(false)->change();
            $table->float('sale_price', 10, 2)->nullable(false)->change();
            $table->float('price', 10, 2)->nullable(false)->change();
        });
    }
};
