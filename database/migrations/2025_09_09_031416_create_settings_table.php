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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->string('type')->default('string'); // string, integer, boolean, json, array
            $table->string('group')->default('general'); // general, video, anti_cheat, suspension, email, etc.
            $table->string('label');
            $table->text('description')->nullable();
            $table->json('options')->nullable(); // For select/radio options
            $table->boolean('is_public')->default(false); // Can be accessed by non-admin users
            $table->boolean('is_editable')->default(true); // Can be edited from admin panel
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            // Video Settings
            [
                'key' => 'video_allow_seeking',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'video',
                'label' => 'Allow Video Seeking',
                'description' => 'Allow users to seek/scrub through videos',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_allow_pausing',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'video',
                'label' => 'Allow Video Pausing',
                'description' => 'Allow users to pause videos during playback',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_min_watch_percentage',
                'value' => '85',
                'type' => 'integer',
                'group' => 'video',
                'label' => 'Minimum Watch Percentage',
                'description' => 'Minimum percentage of video that must be watched to earn reward',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_heartbeat_interval',
                'value' => '10',
                'type' => 'integer',
                'group' => 'video',
                'label' => 'Heartbeat Interval (seconds)',
                'description' => 'How often to send heartbeat signals during video playback',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 4,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'video_countdown_duration',
                'value' => '5',
                'type' => 'integer',
                'group' => 'video',
                'label' => 'Countdown Duration (seconds)',
                'description' => 'Countdown duration before video starts playing',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Anti-Cheat Settings
            [
                'key' => 'anti_cheat_max_seek_count',
                'value' => '3',
                'type' => 'integer',
                'group' => 'anti_cheat',
                'label' => 'Maximum Seek Count',
                'description' => 'Maximum number of seeks allowed per video',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'anti_cheat_max_pause_count',
                'value' => '5',
                'type' => 'integer',
                'group' => 'anti_cheat',
                'label' => 'Maximum Pause Count',
                'description' => 'Maximum number of pauses allowed per video',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 11,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'anti_cheat_require_tab_visible',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'anti_cheat',
                'label' => 'Require Tab Visible',
                'description' => 'Require the browser tab to be visible during video playback',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 12,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'anti_cheat_min_heartbeat_frequency',
                'value' => '0.5',
                'type' => 'decimal',
                'group' => 'anti_cheat',
                'label' => 'Minimum Heartbeat Frequency',
                'description' => 'Minimum frequency of heartbeats per second required',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 13,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Suspension Settings
            [
                'key' => 'suspension_autopilot_enabled',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'suspension',
                'label' => 'Autopilot Enabled',
                'description' => 'Enable automatic approval of suspensions that pass basic tests',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 20,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'suspension_auto_approve_threshold',
                'value' => '90',
                'type' => 'integer',
                'group' => 'suspension',
                'label' => 'Auto-Approve Threshold (%)',
                'description' => 'Minimum watch percentage for auto-approval when autopilot is enabled',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 21,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'suspension_notify_admins',
                'value' => '1',
                'type' => 'boolean',
                'group' => 'suspension',
                'label' => 'Notify Admins on Suspension',
                'description' => 'Send email notifications to admins when users are suspended',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 22,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // Email Settings
            [
                'key' => 'email_admin_address',
                'value' => 'admin@stream2cash.com',
                'type' => 'string',
                'group' => 'email',
                'label' => 'Admin Email Address',
                'description' => 'Email address to receive admin notifications',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 30,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'email_from_name',
                'value' => 'Stream2Cash',
                'type' => 'string',
                'group' => 'email',
                'label' => 'From Name',
                'description' => 'Name used in email sender field',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 31,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // General Settings
            [
                'key' => 'site_name',
                'value' => 'Stream2Cash',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Name',
                'description' => 'Name of the website',
                'is_public' => true,
                'is_editable' => true,
                'sort_order' => 40,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'site_description',
                'value' => 'Earn money by watching videos',
                'type' => 'string',
                'group' => 'general',
                'label' => 'Site Description',
                'description' => 'Brief description of the website',
                'is_public' => true,
                'is_editable' => true,
                'sort_order' => 41,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'key' => 'maintenance_mode',
                'value' => '0',
                'type' => 'boolean',
                'group' => 'general',
                'label' => 'Maintenance Mode',
                'description' => 'Enable maintenance mode to temporarily disable the site',
                'is_public' => false,
                'is_editable' => true,
                'sort_order' => 42,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
