<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('name', 100)->nullable()->change();
            $table->string('link', 100)->nullable()->change();
            $table->string('image', 100)->nullable()->change();
            $table->string('description', 255)->nullable()->change();
            $table->string('position', 100)->nullable()->change();
            $table->tinyInteger('status')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('blogs', function (Blueprint $table) {
            $table->string('name', 100)->nullable(false)->change();
            $table->string('link', 100)->nullable(false)->default('#')->change();
            $table->string('image', 100)->nullable(false)->change();
            $table->string('description', 255)->nullable(false)->change();
            $table->string('position', 100)->nullable(false)->default('top-banner')->change();
            $table->tinyInteger('status')->nullable(false)->default(0)->change();
        });
    }
};

