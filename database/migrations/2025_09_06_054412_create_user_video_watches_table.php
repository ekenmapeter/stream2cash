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
    Schema::create('user_video_watches', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('video_id')->constrained()->onDelete('cascade');
        $table->timestamp('watched_at')->useCurrent();
        $table->decimal('reward_earned', 8, 2)->default(0.00);
        $table->unique(['user_id', 'video_id']); // prevent multiple earnings for same video
    });
}

public function down()
{
    Schema::dropIfExists('user_video_watches');
}

};
