<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Fix tabel battles - tambah kolom yang kurang
        Schema::table('battles', function (Blueprint $table) {
            if (!Schema::hasColumn('battles', 'host_id')) {
                $table->foreignId('host_id')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete()
                      ->after('id');
            }
            if (!Schema::hasColumn('battles', 'max_participants')) {
                $table->integer('max_participants')->default(2)->after('status');
            }
            if (!Schema::hasColumn('battles', 'winner_id')) {
                $table->foreignId('winner_id')
                      ->nullable()
                      ->constrained('users')
                      ->nullOnDelete()
                      ->after('max_participants');
            }
            if (!Schema::hasColumn('battles', 'started_at')) {
                $table->timestamp('started_at')->nullable()->after('winner_id');
            }
            if (!Schema::hasColumn('battles', 'ended_at')) {
                $table->timestamp('ended_at')->nullable()->after('started_at');
            }
        });

        // Buat tabel battle_participants kalau belum ada
        if (!Schema::hasTable('battle_participants')) {
            Schema::create('battle_participants', function (Blueprint $table) {
                $table->id();
                $table->foreignId('battle_id')->constrained()->cascadeOnDelete();
                $table->foreignId('user_id')->constrained()->cascadeOnDelete();
                $table->integer('score')->default(0);
                $table->text('answer')->nullable();
                $table->boolean('is_correct')->nullable();
                $table->boolean('is_ready')->default(false);
                $table->integer('response_time_seconds')->nullable();
                $table->timestamp('submitted_at')->nullable();
                $table->timestamps();
                $table->unique(['battle_id', 'user_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::table('battles', function (Blueprint $table) {
            $table->dropForeign(['host_id']);
            $table->dropForeign(['winner_id']);
            $table->dropColumn(['host_id', 'max_participants', 'winner_id', 'started_at', 'ended_at']);
        });

        Schema::dropIfExists('battle_participants');
    }
};