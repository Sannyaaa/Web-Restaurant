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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->string('name');
            $table->string('phone');
            $table->foreignId('user_id')->nullable();
            $table->foreignId('table_id');
            $table->string('total_price');
            $table->enum('status', ['awaiting_payment', 'being_prepared', 'out_for_delivery','delivered']);
            $table->string('invoice');
            $table->enum('payment_method', ['midtrans', 'ipaymu', 'cash']);
            $table->enum('payment_status', ['paid', 'pending', 'cancelled']);
            $table->string('payment_url')->nullable();

            $table->timestamps();
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
