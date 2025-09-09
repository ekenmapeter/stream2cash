<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Withdrawal;
use App\Models\Earning;
use App\Models\UserVideoWatch;
use App\Models\User;
use App\Services\SuspensionService;
use App\Services\SettingsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{

    /**
     * Show the user dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get real user data from database
        $stats = [
            'available_tasks' => Video::where('status', 'active')->count(),
            'completed_tasks' => $user->watches()->count(),
            'withdrawals' => $user->withdrawals()->count(),
            'wallet_balance' => $user->balance
        ];

        // Get recent earnings (task completions)
        $recent_earnings = $user->earnings()
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get recent withdrawals
        $recent_withdrawals = $user->withdrawals()
            ->orderBy('requested_at', 'desc')
            ->take(5)
            ->get();

        // Get recent tasks (videos)
        $recent_tasks = Video::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Get user's completed tasks
        $user_completed_tasks = $user->watches()
            ->with('video')
            ->orderBy('watched_at', 'desc')
            ->take(5)
            ->get();

        return view('user.dashboard', compact(
            'stats',
            'recent_earnings',
            'recent_withdrawals',
            'recent_tasks',
            'user_completed_tasks'
        ));
    }

    /**
     * Show the user wallet.
     */
    public function wallet()
    {
        $user = Auth::user();

        // Get real wallet data from database
        $wallet_data = [
            'balance' => $user->balance,
            'pending' => $user->withdrawals()->where('status', 'pending')->sum('amount'),
            'total_earned' => $user->earnings()->sum('amount'),
            'total_withdrawn' => $user->withdrawals()->where('status', 'completed')->sum('amount')
        ];

        $recent_withdrawals = $user->withdrawals()
            ->orderBy('requested_at', 'desc')
            ->take(10)
            ->get();

        $recent_earnings = $user->earnings()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('user.wallet', compact('wallet_data', 'recent_withdrawals', 'recent_earnings'));
    }

    /**
     * Show available tasks.
     */
    public function tasks()
    {
        $user = Auth::user();

        // Get real tasks from database
        $tasks = Video::where('status', 'active')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get user's completed task IDs
        $completed_task_ids = $user->watches()->pluck('video_id')->toArray();

        return view('user.tasks', compact('tasks', 'completed_task_ids'));
    }

    /**
     * Show task details with related tasks.
     */
    public function taskDetails(Video $task)
    {
        $user = Auth::user();

        // Check if user has already completed this task
        $isCompleted = $user->watches()->where('video_id', $task->id)->exists();

        // Get related tasks (same category or similar reward range)
        $relatedTasks = Video::where('status', 'active')
            ->where('id', '!=', $task->id)
            ->where(function($query) use ($task) {
                $query->whereBetween('reward_per_view', [$task->reward_per_view * 0.5, $task->reward_per_view * 1.5])
                      ->orWhere('title', 'like', '%' . substr($task->title, 0, 20) . '%');
            })
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        // Get user's completed task IDs for related tasks
        $completed_task_ids = $user->watches()->pluck('video_id')->toArray();

        // Check if it's a YouTube URL
        $isYouTube = preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $task->url, $matches);
        $youtubeId = $isYouTube ? $matches[1] : null;
        $thumbnailUrl = $isYouTube ? "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg" : ($task->thumbnail_url ?? $task->thumbnail ?? 'https://placehold.co/600x300/0000FF/FFFFFF?text=Video');

        return view('user.task-details', compact('task', 'isCompleted', 'relatedTasks', 'completed_task_ids', 'isYouTube', 'youtubeId', 'thumbnailUrl'));
    }

    /**
     * Show watch task page with countdown.
     */
    public function watchTask(Video $task)
    {
        $user = Auth::user();

        // Check if user has already completed this task
        $isCompleted = $user->watches()->where('video_id', $task->id)->exists();

        if ($isCompleted) {
            return redirect()->route('user.tasks.details', $task)->with('error', 'You have already completed this task.');
        }

        // Check if it's a YouTube URL
        $isYouTube = preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $task->url, $matches);
        $youtubeId = $isYouTube ? $matches[1] : null;
        $thumbnailUrl = $isYouTube ? "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg" : ($task->thumbnail_url ?? $task->thumbnail ?? 'https://placehold.co/600x300/0000FF/FFFFFF?text=Video');

        // Get video settings
        $settingsService = new SettingsService();
        $videoSettings = [
            'allow_seeking' => $settingsService->isVideoSeekingAllowed(),
            'allow_pausing' => $settingsService->isVideoPausingAllowed(),
            'countdown_duration' => $settingsService->getCountdownDuration(),
            'heartbeat_interval' => $settingsService->getHeartbeatInterval(),
        ];

        return view('user.watch-task', compact('task', 'isYouTube', 'youtubeId', 'thumbnailUrl', 'videoSettings'));
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        $user = Auth::user();

        $stats = [
            'tasks_completed' => $user->watches()->count(),
            'total_earned' => $user->earnings()->sum('amount'),
            'withdrawals' => $user->withdrawals()->count(),
        ];

        $lastWithdrawal = $user->withdrawals()
            ->orderByDesc('requested_at')
            ->first();

        // Build recent activities feed from earnings and withdrawals
        $recentEarnings = $user->earnings()
            ->select(['id', 'amount', 'created_at'])
            ->orderByDesc('created_at')
            ->take(10)
            ->get()
            ->map(function ($e) {
                return [
                    'type' => 'earning',
                    'description' => 'Task reward',
                    'amount' => $e->amount,
                    'status' => 'completed',
                    'date' => $e->created_at,
                ];
            });

        $recentWithdrawals = $user->withdrawals()
            ->select(['id', 'amount', 'status', 'requested_at', 'method'])
            ->orderByDesc('requested_at')
            ->take(10)
            ->get()
            ->map(function ($w) {
                return [
                    'type' => 'withdrawal',
                    'description' => $w->method ?: 'Withdrawal',
                    'amount' => $w->amount,
                    'status' => $w->status,
                    'date' => $w->requested_at,
                ];
            });

        $activities = $recentEarnings
            ->merge($recentWithdrawals)
            ->sortByDesc('date')
            ->values();

        return view('user.profile', compact('user', 'stats', 'lastWithdrawal', 'activities'));
    }

    /**
     * Show withdrawal page.
     */
    public function withdrawal()
    {
        $user = Auth::user();

        // Get real withdrawal data from database
        $withdrawal_data = [
            'balance' => $user->balance,
            'min_withdrawal' => 1000, // You can make this configurable
            'withdrawal_methods' => ['Bank Transfer', 'PayPal', 'Mobile Money'],
            'recent_withdrawals' => $user->withdrawals()
                ->orderBy('requested_at', 'desc')
                ->take(10)
                ->get()
        ];

        return view('user.withdrawal', compact('withdrawal_data'));
    }

    /**
     * Handle video completion and reward user.
     */
    public function completeVideo(Request $request)
    {
        // 1. Validate the incoming request
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'video_id' => 'required|exists:videos,id',
            'watch_duration' => 'required|integer|min:0',
            'video_duration' => 'required|integer|min:1',
            'watch_percentage' => 'required|numeric|min:0|max:100',
            'seek_count' => 'required|integer|min:0',
            'pause_count' => 'required|integer|min:0',
            'heartbeat_count' => 'required|integer|min:0',
            'tab_visible' => 'required|boolean',
            'watch_events' => 'required|array',
            'is_valid' => 'required|boolean',
            'validation_notes' => 'nullable|array'
        ]);

        $userId = $request->input('user_id');
        $videoId = $request->input('video_id');
        $user = User::find($userId);

        // Security check: ensure the authenticated user is the one making the request
        if (Auth::id() != $userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        // 2. Check if the user has already been rewarded for this video
        $hasCompleted = UserVideoWatch::where('user_id', $userId)
                                       ->where('video_id', $videoId)
                                       ->exists();

        if ($hasCompleted) {
            return response()->json(['success' => false, 'message' => 'You have already earned points for this video.'], 409);
        }

        // 3. Get the video to determine reward amount
        $video = Video::find($videoId);
        if (!$video || $video->status !== 'active') {
            return response()->json(['success' => false, 'message' => 'Video not available or inactive.'], 404);
        }

        // 4. Server-side validation using settings
        $settingsService = new SettingsService();
        $watchPercentage = $request->input('watch_percentage');
        $seekCount = $request->input('seek_count');
        $pauseCount = $request->input('pause_count');
        $tabVisible = $request->input('tab_visible');
        $heartbeatCount = $request->input('heartbeat_count');
        $watchDuration = $request->input('watch_duration');
        $videoDuration = $request->input('video_duration');

        $validationNotes = [];
        $isValid = true;

        // Get settings values
        $minWatchPercentage = $settingsService->getMinWatchPercentage();
        $maxSeekCount = $settingsService->getMaxSeekCount();
        $maxPauseCount = $settingsService->getMaxPauseCount();
        $requireTabVisible = $settingsService->isTabVisibilityRequired();
        $minHeartbeatFrequency = $settingsService->getMinHeartbeatFrequency();

        // Minimum watch percentage
        if ($watchPercentage < $minWatchPercentage) {
            $isValid = false;
            $validationNotes[] = "Watched only {$watchPercentage}% of video (minimum {$minWatchPercentage}% required)";
        }

        // Maximum seek count
        if ($seekCount > $maxSeekCount) {
            $isValid = false;
            $validationNotes[] = "Too many seeks: {$seekCount} (maximum {$maxSeekCount} allowed)";
        }

        // Maximum pause count
        if ($pauseCount > $maxPauseCount) {
            $isValid = false;
            $validationNotes[] = "Too many pauses: {$pauseCount} (maximum {$maxPauseCount} allowed)";
        }

        // Tab visibility check
        if ($requireTabVisible && !$tabVisible) {
            $isValid = false;
            $validationNotes[] = "Tab was not visible during video playback";
        }

        // Heartbeat frequency check
        $heartbeatInterval = $settingsService->getHeartbeatInterval();
        $expectedHeartbeats = floor($watchDuration / $heartbeatInterval);
        $minRequiredHeartbeats = $expectedHeartbeats * $minHeartbeatFrequency;
        if ($heartbeatCount < $minRequiredHeartbeats) {
            $isValid = false;
            $validationNotes[] = "Insufficient heartbeat activity detected (expected: {$expectedHeartbeats}, got: {$heartbeatCount})";
        }

        // If validation fails, handle cheating attempt
        if (!$isValid) {
            // Prepare cheat evidence data
            $cheatEvidence = [
                'watch_duration' => $watchDuration,
                'video_duration' => $videoDuration,
                'watch_percentage' => $watchPercentage,
                'seek_count' => $seekCount,
                'pause_count' => $pauseCount,
                'heartbeat_count' => $heartbeatCount,
                'tab_visible' => $tabVisible,
                'watch_events' => $request->input('watch_events'),
                'validation_notes' => $validationNotes
            ];

            // Use suspension service to handle cheating attempt
            $suspensionService = new SuspensionService();
            $suspension = $suspensionService->handleCheatingAttempt($user, $video, $cheatEvidence, $validationNotes);

            // Log the invalid attempt
            UserVideoWatch::create([
                'user_id' => $userId,
                'video_id' => $videoId,
                'watched_at' => now(),
                'reward_earned' => 0,
                'watch_duration' => $watchDuration,
                'video_duration' => $videoDuration,
                'watch_percentage' => $watchPercentage,
                'seek_count' => $seekCount,
                'pause_count' => $pauseCount,
                'heartbeat_count' => $heartbeatCount,
                'tab_visible' => $tabVisible,
                'watch_events' => $request->input('watch_events'),
                'is_valid' => false,
                'validation_notes' => $validationNotes
            ]);

            // Check if user was auto-approved
            if ($suspension->isAutoApproved()) {
                return response()->json([
                    'success' => true,
                    'points' => $video->reward_per_view,
                    'message' => 'Points awarded after review!',
                    'new_balance' => $user->fresh()->balance,
                    'auto_approved' => true
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Your video completion is under review. Your account has been temporarily suspended pending admin approval.',
                'validation_notes' => $validationNotes,
                'suspended' => true,
                'suspension_id' => $suspension->id
            ], 400);
        }

        $pointsToAward = $video->reward_per_view;

        // 5. Reward the user
        $user->balance += $pointsToAward;
        $user->save();

        // 6. Log the completion with detailed tracking data
        UserVideoWatch::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'watched_at' => now(),
            'reward_earned' => $pointsToAward,
            'watch_duration' => $watchDuration,
            'video_duration' => $videoDuration,
            'watch_percentage' => $watchPercentage,
            'seek_count' => $seekCount,
            'pause_count' => $pauseCount,
            'heartbeat_count' => $heartbeatCount,
            'tab_visible' => $tabVisible,
            'watch_events' => $request->input('watch_events'),
            'is_valid' => true,
            'validation_notes' => null
        ]);

        // 7. Create earning record
        Earning::create([
            'user_id' => $userId,
            'video_id' => $videoId,
            'amount' => $pointsToAward,
            'type' => 'video_completion',
        ]);

        return response()->json([
            'success' => true,
            'points' => $pointsToAward,
            'message' => 'Points awarded successfully!',
            'new_balance' => $user->balance
        ]);
    }

    /**
     * Handle video heartbeat for anti-cheat monitoring.
     */
    public function videoHeartbeat(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'video_id' => 'required|exists:videos,id',
            'current_time' => 'required|integer|min:0',
            'seek_count' => 'required|integer|min:0',
            'pause_count' => 'required|integer|min:0',
            'tab_visible' => 'required|boolean'
        ]);

        $userId = $request->input('user_id');

        // Security check
        if (Auth::id() != $userId) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        // Log heartbeat for monitoring (you can store this in a separate table if needed)
        // For now, we'll just return success
        return response()->json(['success' => true]);
    }
}
