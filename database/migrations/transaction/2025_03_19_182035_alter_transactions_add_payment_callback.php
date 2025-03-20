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
        Schema::table('transactions', function (Blueprint $table) {
            $table->json('payment_callback')->nullable()->comment('Payment Xendit Callback');
        });
        Schema::table('_history_transactions', function (Blueprint $table) {
            $table->json('payment_callback')->nullable()->comment('Payment Xendit Callback');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('payment_callback');
        });
        Schema::table('_history_transactions', function (Blueprint $table) {
            $table->dropColumn('payment_callback');
        });
    }
};
