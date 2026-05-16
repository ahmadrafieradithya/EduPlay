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
        Schema::create('battle_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('battle_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->integer('score')->default(0);
            $table->boolean('is_winner')->default(false);
            $table->integer('accuracy')->default(0);
            $table->integer('time_seconds')->default(0);
            $table->json('details')->nullable();
            $table->timestamps();

            $table->unique(['battle_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battle_results');
    }
};
