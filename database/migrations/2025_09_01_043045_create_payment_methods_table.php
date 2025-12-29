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
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->constrained()
                ->onDelete('cascade');

            $table->foreignId('gateway_id')
                ->constrained('payment_gateways')
                ->onDelete('cascade');
            $table->enum('type', [
                'card',
                'bank',
                'wallet',
                'upi',
                'paypal',
                'crypto',
                'cod',
                'bnpl',
                'other',
            ])->default('card');
            $table->string('token', 255);
            $table->string('label')->nullable();
            $table->json('details')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
