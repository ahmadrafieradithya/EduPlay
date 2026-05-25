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
        Schema::table('game_sessions', function (Blueprint $table) {
            if (!Schema::hasColumn('game_sessions', 'status')) {
                $table->string('status')->default('in_progress')->after('duration_seconds');
            }
            if (!Schema::hasColumn('game_sessions', 'completed_at')) {
                $table->timestamp('completed_at')->nullable()->after('status');
            }
            if (!Schema::hasColumn('game_sessions', 'metadata')) {
                $table->json('metadata')->nullable()->after('completed_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('game_sessions', function (Blueprint $table) {
            if (Schema::hasColumn('game_sessions', 'status')) {
                $table->dropColumn('status');
            }
            if (Schema::hasColumn('game_sessions', 'completed_at')) {
                $table->dropColumn('completed_at');
            }
            if (Schema::hasColumn('game_sessions', 'metadata')) {
                $table->dropColumn('metadata');
            }
        });
    }
};
