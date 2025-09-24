<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $tables = [
            'users',
            'videos',
            'earnings',
            'user_video_watches',
            'withdrawals',
            'suspension_orchestrations',
        ];

        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (!Schema::hasColumn($table->getTable(), 'uid')) {
                    $table->uuid('uid')->nullable()->unique()->after('id');
                }
            });
        }

        // Backfill uids
        foreach ($tables as $table) {
            DB::table($table)->whereNull('uid')->update(['uid' => DB::raw('(UUID())')]);
        }

        // Set not null
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                $table->uuid('uid')->nullable(false)->change();
            });
        }
    }

    public function down(): void
    {
        $tables = [
            'users',
            'videos',
            'earnings',
            'user_video_watches',
            'withdrawals',
            'suspension_orchestrations',
        ];
        foreach ($tables as $table) {
            Schema::table($table, function (Blueprint $table) {
                if (Schema::hasColumn($table->getTable(), 'uid')) {
                    $table->dropUnique($table->getTable().'_uid_unique');
                    $table->dropColumn('uid');
                }
            });
        }
    }
};


