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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->integer('transaction_id')->nullable();
            $table->integer('customer_id')->nullable();
            $table->float('money')->nullable();
            $table->string('note')->nullable();
            $table->string('vnp_response_code', 255)->nullable();
            $table->string('code_vnpay', 255)->nullable();
            $table->string('code_bank', 255)->nullable();
            $table->dateTime('time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
