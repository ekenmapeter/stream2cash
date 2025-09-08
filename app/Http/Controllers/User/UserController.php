<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Withdrawal;
use App\Models\Earning;
use App\Models\UserVideoWatch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
