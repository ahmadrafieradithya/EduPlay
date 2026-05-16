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
        Schema::create('battles', function (Blueprint $table) {
            $table->id();
            $table->string('code', 8)->unique();
            $table->foreignId('challenger_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('opponent_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('game_level_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['waiting', 'ready', 'in_progress', 'finished', 'cancelled'])->default('waiting');
            $table->foreignId('winner_id')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('ended_at')->nullable();
            $table->timestamps();

            $table->index(['challenger_id', 'opponent_id', 'game_level_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('battles');
    }
};
