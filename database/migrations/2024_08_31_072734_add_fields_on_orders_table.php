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
        Schema::table('orders', function (Blueprint $table) {
            //

            $table->string('chef')->after('total_price')->nullable();
            $table->string('waiter')->after('chef')->nullable();
            $table->string('cashier')->after('waiter')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //

            $table->dropColumn('chef');
            $table->dropColumn('waiter');
            $table->dropColumn('cashier');

        });
    }
};
