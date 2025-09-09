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
        Schema::table('user_video_watches', function (Blueprint $table) {
            $table->integer('watch_duration')->default(0)->after('reward_earned'); // in seconds
            $table->integer('video_duration')->default(0)->after('watch_duration'); // in seconds
            $table->decimal('watch_percentage', 5, 2)->default(0)->after('video_duration'); // percentage watched
            $table->integer('seek_count')->default(0)->after('watch_percentage'); // number of seeks
            $table->integer('pause_count')->default(0)->after('seek_count'); // number of pauses
            $table->integer('heartbeat_count')->default(0)->after('pause_count'); // number of heartbeats received
            $table->boolean('tab_visible')->default(true)->after('heartbeat_count'); // was tab visible during watch
            $table->json('watch_events')->nullable()->after('tab_visible'); // detailed watch events
            $table->boolean('is_valid')->default(true)->after('watch_events'); // validation result
            $table->text('validation_notes')->nullable()->after('is_valid'); // validation failure reasons
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('user_video_watches', function (Blueprint $table) {
            $table->dropColumn([
                'watch_duration',
                'video_duration',
                'watch_percentage',
                'seek_count',
                'pause_count',
                'heartbeat_count',
                'tab_visible',
                'watch_events',
                'is_valid',
                'validation_notes'
            ]);
        });
    }
};
