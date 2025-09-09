<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Update the earnings type enum to include video_completion
        DB::statement("ALTER TABLE earnings MODIFY COLUMN type ENUM('watch', 'bonus', 'referral', 'video_completion') DEFAULT 'watch'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert back to original enum values
        DB::statement("ALTER TABLE earnings MODIFY COLUMN type ENUM('watch', 'bonus', 'referral') DEFAULT 'watch'");
    }
};
