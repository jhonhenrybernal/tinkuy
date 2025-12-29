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
            $table->foreignId('order_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('gateway_id')
                ->constrained('payment_gateways')
                ->onDelete('cascade');

            $table->decimal('amount', 12, 2);
            $table->string('currency', 10)->default('USD');

            $table->enum('status', [
                'pending',
                'processing',
                'completed',
                'failed',
                'refunded',
            ])->default('pending');

            $table->string('transaction_id', 255)->nullable();

            $table->json('response')->nullable();

            $table->json('meta')->nullable();
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
