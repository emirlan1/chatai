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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('inv_id')->unique();
            $table->timestamp('invoice_date')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->foreignId('user_id');
            $table->tinyInteger('status')->default(0); // 0 - unpaid, 1 - paid
            $table->integer('gpt3_tokens')->default(0);
            $table->integer('gpt4_tokens')->default(0);
            $table->string('tariff_name');
            $table->timestamp('tariff_expiry_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
