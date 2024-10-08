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
        Schema::create('cart_trackings', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['in_progress', 'pending', 'approved', 'is_shipped', 'delivered']);
            $table->unsignedBigInteger('cart_id');
            $table->dateTime('datetime');
            $table->timestamps();
    
            $table->foreign('cart_id')->on('carts')->references('id')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_trackings');
    }
};
