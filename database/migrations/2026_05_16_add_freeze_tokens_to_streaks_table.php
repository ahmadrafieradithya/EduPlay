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
        Schema::table('streaks', function (Blueprint $table) {
            if (!Schema::hasColumn('streaks', 'freeze_tokens')) {
                $table->integer('freeze_tokens')->default(0)->after('last_activity_date');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('streaks', function (Blueprint $table) {
            $table->dropColumn('freeze_tokens');
        });
    }
};
