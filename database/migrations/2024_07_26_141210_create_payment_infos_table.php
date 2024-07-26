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
        Schema::create('payment_infos', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('payment_gateway');
            $table->string('public_key');
            $table->string('secret_key');
            $table->string('additional_info');
            $table->unsignedBigInteger('vendor_id');
            $table->timestamps();
    
            $table->foreign('vendor_id')->on('vendors')->references('id')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_infos');
    }
};
