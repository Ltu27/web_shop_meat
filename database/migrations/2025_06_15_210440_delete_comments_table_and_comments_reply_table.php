<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Drop the child table first due to foreign key constraint
        Schema::dropIfExists('comment_replies');
        Schema::dropIfExists('comments');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate comments table
        Schema::create('comments', function ($table) {
            $table->increments('id');
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('product_id');
            $table->text('comment');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('product_id')->references('id')->on('products');
        });

        // Recreate comment_replies table
        Schema::create('comment_replies', function ($table) {
            $table->id();
            $table->unsignedInteger('customer_id');
            $table->unsignedInteger('comment_id');
            $table->text('comment');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('comment_id')->references('id')->on('comments');
        });
    }
};
