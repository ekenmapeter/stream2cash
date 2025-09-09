<?php

namespace App\Services;

use App\Models\User;
use App\Models\Video;
use App\Models\SuspensionOrchestration;
use App\Models\UserVideoWatch;
use App\Notifications\CheatingAttemptNotification;
use App\Services\SettingsService;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class SuspensionService
{
    /**
     * Handle cheating attempt and create suspension
     */
    public function handleCheatingAttempt(User $user, Video $video, array $cheatData, array $validationNotes)
    {
        // Create suspension orchestration record
        $suspension = SuspensionOrchestration::create([
            'user_id' => $user->id,
            'video_id' => $video->id,
            'suspension_type' => 'cheating',
            'status' => 'pending',
            'reason' => 'Video completion validation failed - suspected cheating',
            'cheat_evidence' => $cheatData,
            'amount_involved' => $video->reward_per_view,
            'wallet_credited' => false,
            'email_sent' => false,
            'suspended_at' => now(),
            'autopilot_enabled' => $this->isAutopilotEnabled()
        ]);

        // Log the cheating attempt
        Log::warning('Cheating attempt detected', [
            'user_id' => $user->id,
            'video_id' => $video->id,
            'suspension_id' => $suspension->id,
            'evidence' => $cheatData,
            'validation_notes' => $validationNotes
        ]);

        // Check if autopilot is enabled
        if ($suspension->autopilot_enabled) {
            return $this->handleAutopilotApproval($suspension);
        }

        // Send email notification to admins
        $this->notifyAdmins($suspension);

        // Suspend user account
        $this->suspendUser($user, $suspension);

        return $suspension;
    }

    /**
     * Handle autopilot approval
     */
    public function handleAutopilotApproval(SuspensionOrchestration $suspension)
    {
        // Check if this is a minor violation that can be auto-approved
        $evidence = $suspension->cheat_evidence;
        $canAutoApprove = $this->canAutoApprove($evidence);

        if ($canAutoApprove) {
            // Auto-approve and credit wallet
            $suspension->autoApprove('Auto-approved: Minor violation within acceptable limits');
            $this->creditUserWallet($suspension);

            Log::info('Suspension auto-approved', [
                'suspension_id' => $suspension->id,
                'user_id' => $suspension->user_id
            ]);

            return $suspension;
        }

        // Send email notification for manual review
        $this->notifyAdmins($suspension);
        $this->suspendUser($suspension->user, $suspension);

        return $suspension;
    }

    /**
     * Check if autopilot is enabled
     */
    private function isAutopilotEnabled()
    {
        $settingsService = new SettingsService();
        return $settingsService->isAutopilotEnabled();
    }

    /**
     * Check if suspension can be auto-approved
     */
    private function canAutoApprove(array $evidence)
    {
        $settingsService = new SettingsService();
        $watchPercentage = $evidence['watch_percentage'] ?? 0;
        $seekCount = $evidence['seek_count'] ?? 0;
        $pauseCount = $evidence['pause_count'] ?? 0;
        $tabVisible = $evidence['tab_visible'] ?? false;

        $autoApproveThreshold = $settingsService->getAutoApproveThreshold();
        $maxSeekCount = $settingsService->getMaxSeekCount();
        $maxPauseCount = $settingsService->getMaxPauseCount();
        $requireTabVisible = $settingsService->isTabVisibilityRequired();

        // Auto-approve if all conditions are met
        return $watchPercentage >= $autoApproveThreshold &&
               $seekCount <= $maxSeekCount &&
               $pauseCount <= $maxPauseCount &&
               (!$requireTabVisible || $tabVisible);
    }

    /**
     * Notify admins about cheating attempt
     */
    private function notifyAdmins(SuspensionOrchestration $suspension)
    {
        try {
            // Get all admin users
            $admins = User::where('role', 'admin')->get();

            if ($admins->count() > 0) {
                Notification::send($admins, new CheatingAttemptNotification($suspension));

                // Mark email as sent
                $suspension->update(['email_sent' => true]);

                Log::info('Cheating attempt notification sent to admins', [
                    'suspension_id' => $suspension->id,
                    'admin_count' => $admins->count()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Failed to send cheating notification', [
                'suspension_id' => $suspension->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Suspend user account
     */
    private function suspendUser(User $user, SuspensionOrchestration $suspension)
    {
        $user->suspend('Cheating attempt detected - Video ID: ' . $suspension->video_id);

        Log::info('User suspended due to cheating', [
            'user_id' => $user->id,
            'suspension_id' => $suspension->id
        ]);
    }

    /**
     * Credit user wallet after approval
     */
    public function creditUserWallet(SuspensionOrchestration $suspension)
    {
        if ($suspension->wallet_credited) {
            return; // Already credited
        }

        $user = $suspension->user;
        $amount = $suspension->amount_involved;

        // Credit the user's wallet
        $user->balance += $amount;
        $user->save();

        // Create earning record
        \App\Models\Earning::create([
            'user_id' => $user->id,
            'video_id' => $suspension->video_id,
            'amount' => $amount,
            'type' => 'video_completion_approved'
        ]);

        // Create video watch record
        UserVideoWatch::create([
            'user_id' => $user->id,
            'video_id' => $suspension->video_id,
            'watched_at' => now(),
            'reward_earned' => $amount,
            'watch_duration' => $suspension->cheat_evidence['watch_duration'] ?? 0,
            'video_duration' => $suspension->cheat_evidence['video_duration'] ?? 0,
            'watch_percentage' => $suspension->cheat_evidence['watch_percentage'] ?? 0,
            'seek_count' => $suspension->cheat_evidence['seek_count'] ?? 0,
            'pause_count' => $suspension->cheat_evidence['pause_count'] ?? 0,
            'heartbeat_count' => $suspension->cheat_evidence['heartbeat_count'] ?? 0,
            'tab_visible' => $suspension->cheat_evidence['tab_visible'] ?? false,
            'watch_events' => $suspension->cheat_evidence['watch_events'] ?? [],
            'is_valid' => true,
            'validation_notes' => null
        ]);

        // Mark as credited
        $suspension->update(['wallet_credited' => true]);

        // Reactivate user if they were suspended
        if ($user->isSuspended()) {
            $user->activate();
        }

        Log::info('User wallet credited after suspension approval', [
            'user_id' => $user->id,
            'suspension_id' => $suspension->id,
            'amount' => $amount
        ]);
    }

    /**
     * Reject suspension and keep user suspended
     */
    public function rejectSuspension(SuspensionOrchestration $suspension, $adminId, $notes = null)
    {
        $suspension->reject($adminId, $notes);

        Log::info('Suspension rejected', [
            'suspension_id' => $suspension->id,
            'admin_id' => $adminId,
            'notes' => $notes
        ]);
    }

    /**
     * Get suspension statistics
     */
    public function getSuspensionStats()
    {
        return [
            'total_pending' => SuspensionOrchestration::pending()->count(),
            'total_approved' => SuspensionOrchestration::approved()->count(),
            'total_rejected' => SuspensionOrchestration::rejected()->count(),
            'total_auto_approved' => SuspensionOrchestration::where('status', 'auto_approved')->count(),
            'cheating_attempts' => SuspensionOrchestration::cheating()->count(),
            'total_amount_involved' => SuspensionOrchestration::sum('amount_involved')
        ];
    }
}
