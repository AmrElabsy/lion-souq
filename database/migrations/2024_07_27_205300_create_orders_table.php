<?php

use App\Models\Order;
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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id');
            $table->double('total');
            $table->enum('status', [Order::PENDING, Order::APPROVED, Order::IS_SHIPPED, Order::DELIVERED]);
            $table->timestamps();
            
            $table->foreign('user_id')->on('users')->references('id')->onDelete('CASCADE');
            $table->foreign('vendor_id')->on('vendors')->references('id')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
