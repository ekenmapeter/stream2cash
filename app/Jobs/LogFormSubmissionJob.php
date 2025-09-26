<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class LogFormSubmissionJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $adminId;
    public int $targetUserId;
    public string $action;
    public string $description;
    public ?array $newData;
    public ?string $ipAddress;
    public ?string $userAgent;

    /**
     * Create a new job instance.
     */
    public function __construct(
        int $adminId,
        int $targetUserId,
        string $action,
        string $description,
        ?array $newData,
        ?string $ipAddress,
        ?string $userAgent
    ) {
        $this->adminId = $adminId;
        $this->targetUserId = $targetUserId;
        $this->action = $action;
        $this->description = $description;
        $this->newData = $newData;
        $this->ipAddress = $ipAddress;
        $this->userAgent = $userAgent;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Truncate oversized payloads defensively
        $newData = $this->newData;
        if (is_array($newData)) {
            $json = json_encode($newData, JSON_UNESCAPED_UNICODE);
            if ($json !== false && strlen($json) > 4000) {
                $json = substr($json, 0, 4000);
                $newData = ['truncated' => true, 'data' => $json];
            }
        }

        DB::table('user_action_logs')->insert([
            'admin_id' => $this->adminId,
            'target_user_id' => $this->targetUserId,
            'action' => $this->action,
            'description' => $this->description,
            'old_data' => null,
            'new_data' => isset($newData) ? json_encode($newData, JSON_UNESCAPED_UNICODE) : null,
            'ip_address' => $this->ipAddress,
            'user_agent' => $this->userAgent,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}


