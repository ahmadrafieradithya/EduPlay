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
        Schema::table('games', function (Blueprint $table) {
            if (!Schema::hasColumn('games', 'slug')) {
                $table->string('slug')->unique()->after('title');
            }
            if (!Schema::hasColumn('games', 'icon')) {
                $table->string('icon')->nullable()->after('type');
            }
        });

        Schema::table('game_levels', function (Blueprint $table) {
            if (!Schema::hasColumn('game_levels', 'description')) {
                $table->text('description')->nullable()->after('title');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('games', function (Blueprint $table) {
            $table->dropColumn(['slug', 'icon']);
        });

        Schema::table('game_levels', function (Blueprint $table) {
            $table->dropColumn('description');
        });
    }
};
