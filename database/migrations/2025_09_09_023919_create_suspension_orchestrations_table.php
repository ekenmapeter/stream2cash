<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('suspension_orchestrations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('video_id')->nullable()->constrained()->onDelete('set null');
            $table->enum('suspension_type', ['cheating', 'manual', 'system'])->default('cheating');
            $table->enum('status', ['pending', 'approved', 'rejected', 'auto_approved'])->default('pending');
            $table->text('reason');
            $table->json('cheat_evidence')->nullable(); // Store detailed cheating evidence
            $table->decimal('amount_involved', 10, 2)->default(0); // Amount that was attempted to be earned
            $table->boolean('wallet_credited')->default(false); // Whether wallet was credited
            $table->boolean('email_sent')->default(false); // Whether admin was notified
            $table->timestamp('suspended_at')->nullable();
            $table->timestamp('resolved_at')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->text('admin_notes')->nullable();
            $table->boolean('autopilot_enabled')->default(false); // Auto-approve if enabled
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('suspension_orchestrations');
    }
};
