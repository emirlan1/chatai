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
        Schema::create('openai', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('chat_id');
            $table->foreign('chat_id')->references('id')->on('chats');
            $table->string('model');
            $table->integer('input_tokens')->nullable();
            $table->integer('output_tokens')->nullable();
            $table->integer('seconds')->nullable();
            $table->text('content');
            $table->float('executionTime')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('openai');
    }
};
