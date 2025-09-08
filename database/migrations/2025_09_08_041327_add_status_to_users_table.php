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
        Schema::table('users', function (Blueprint $table) {
            $table->enum('status', ['active', 'suspended', 'blocked'])->default('active')->after('role');
            $table->timestamp('suspended_at')->nullable()->after('status');
            $table->timestamp('blocked_at')->nullable()->after('suspended_at');
            $table->text('suspension_reason')->nullable()->after('blocked_at');
            $table->text('block_reason')->nullable()->after('suspension_reason');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status', 'suspended_at', 'blocked_at', 'suspension_reason', 'block_reason']);
        });
    }
};
