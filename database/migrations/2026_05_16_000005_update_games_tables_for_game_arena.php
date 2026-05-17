<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add missing columns to games table
        if (Schema::hasTable('games') && !Schema::hasColumn('games', 'difficulty')) {
            Schema::table('games', function (Blueprint $table) {
                $table->string('description')->nullable()->after('title');
                $table->string('thumbnail')->nullable()->after('description');
                $table->enum('difficulty', ['easy', 'medium', 'hard', 'expert'])->default('easy')->after('type');
                $table->boolean('is_published')->default(true)->after('is_active');
            });
        }

        // Add missing columns to game_sessions table
        if (Schema::hasTable('game_sessions') && !Schema::hasColumn('game_sessions', 'game_level_id')) {
            Schema::table('game_sessions', function (Blueprint $table) {
                $table->foreignId('game_level_id')->nullable()->constrained()->nullOnDelete()->after('game_id');
                $table->boolean('is_passed')->default(false)->after('score');
            });
        }

        // Recreate game_scores table with correct schema
        if (Schema::hasTable('game_scores')) {
            Schema::drop('game_scores');
        }

        Schema::create('game_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('game_id')->constrained()->cascadeOnDelete();
            $table->integer('best_score')->default(0);
            $table->integer('total_plays')->default(0);
            $table->timestamps();

            $table->unique(['user_id', 'game_id']);
        });
    }

    public function down(): void
    {
        if (Schema::hasTable('games')) {
            Schema::table('games', function (Blueprint $table) {
                if (Schema::hasColumn('games', 'is_published')) {
                    $table->dropColumn('is_published');
                }
                if (Schema::hasColumn('games', 'difficulty')) {
                    $table->dropColumn('difficulty');
                }
                if (Schema::hasColumn('games', 'thumbnail')) {
                    $table->dropColumn('thumbnail');
                }
                if (Schema::hasColumn('games', 'description')) {
                    $table->dropColumn('description');
                }
            });
        }

        if (Schema::hasTable('game_sessions')) {
            Schema::table('game_sessions', function (Blueprint $table) {
                if (Schema::hasColumn('game_sessions', 'is_passed')) {
                    $table->dropColumn('is_passed');
                }
                if (Schema::hasColumn('game_sessions', 'game_level_id')) {
                    $table->dropForeign(['game_level_id']);
                    $table->dropColumn('game_level_id');
                }
            });
        }

        if (Schema::hasTable('game_scores')) {
            Schema::drop('game_scores');
        }
    }
};
