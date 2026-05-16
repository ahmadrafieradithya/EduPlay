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
        Schema::create('game_levels', function (Blueprint $table) {
            $table->id();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->integer('level_number');
            $table->string('title');
            $table->json('content');
            $table->integer('time_limit')->default(60);
            $table->integer('xp_reward')->default(20);
            $table->integer('min_score_to_pass')->default(70);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['game_id', 'level_number']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('game_levels');
    }
};
