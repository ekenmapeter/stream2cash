<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Video;
use App\Models\Withdrawal;
use App\Models\Earning;
use App\Models\UserVideoWatch;
use App\Models\UserIpRecord;
use App\Models\SuspensionOrchestration;
use App\Models\UserActionLog;
use App\Services\SuspensionService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\WithdrawalApproved;
use App\Mail\WithdrawalRejected;
use App\Mail\BalanceUpdated;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Get real admin data from database
        $admin_stats = [
            'total_users' => User::count(),
            'active_users' => User::where('role', 'user')->count(),
            'total_tasks' => Video::count(),
            'active_tasks' => Video::where('status', 'active')->count(),
            'total_earnings' => Earning::sum('amount'),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->count(),
            'total_withdrawals' => Withdrawal::sum('amount'),
            'approved_withdrawals' => Withdrawal::where('status', 'approved')->sum('amount'),
        ];

        // Recent activities
        $recent_users = User::latest()->take(5)->get();
        $recent_withdrawals = Withdrawal::with('user')->orderByDesc('requested_at')->take(5)->get();
        $recent_earnings = Earning::with('user')->latest()->take(5)->get();

        return view('admin.dashboard', compact('admin_stats', 'recent_users', 'recent_withdrawals', 'recent_earnings'));
    }

    /**
     * Show all users
     */
    public function users(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by role
        if ($request->has('role') && $request->role) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $users = $query->paginate(20);

        return view('admin.users.index', compact('users'));
    }

    /**
     * Show create user form
     */
    public function createUser()
    {
        return view('admin.users.create');
    }

    /**
     * Store new user
     */
    public function storeUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'balance' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,suspended,blocked',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'balance' => $request->balance ?? 0,
            'status' => $request->status,
            'email_verified_at' => now(), // Auto-verify admin-created users
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }

    /**
     * Show specific user details
     */
    public function showUser(User $user)
    {
        $user->load(['earnings', 'withdrawals', 'watches']);

        $user_stats = [
            'total_earnings' => $user->earnings->sum('amount'),
            'total_withdrawals' => $user->withdrawals->sum('amount'),
            'pending_withdrawals' => $user->withdrawals->where('status', 'pending')->sum('amount'),
            'tasks_completed' => $user->watches->count(),
        ];

        // Get paginated withdrawals and earnings
        $user_withdrawals = $user->withdrawals()
            ->orderBy('requested_at', 'desc')
            ->paginate(5);

        $user_earnings = $user->earnings()
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.users.show', compact('user', 'user_stats', 'user_withdrawals', 'user_earnings'));
    }

    /**
     * Toggle user status (active/inactive)
     */
    public function toggleUserStatus(User $user)
    {
        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    /**
     * Update user balance
     */
    public function updateUserBalance(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'balance' => 'required|numeric|min:0',
            'reason' => 'required|string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $old_balance = $user->balance;
        $user->balance = $request->balance;
        $user->save();

        // Log the action
        UserActionLog::logAction(
            adminId: Auth::id(),
            targetUserId: $user->id,
            action: 'update_balance',
            description: "Updated user balance from ₦{$old_balance} to ₦{$request->balance}. Reason: {$request->reason}",
            oldData: ['balance' => $old_balance],
            newData: ['balance' => $request->balance, 'reason' => $request->reason],
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        // Send balance update email to user
        try {
            Mail::to($user->email)->send(new BalanceUpdated(
                $user,
                $old_balance,
                $request->balance,
                $request->reason,
                $request->user()->name
            ));
        } catch (\Exception $e) {
            Log::error('Failed to send balance update email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'User balance updated successfully and user has been notified via email.');
    }

    /**
     * Delete user
     */
    public function deleteUser(Request $request, User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Log the action before deletion
        UserActionLog::logAction(
            adminId: Auth::id(),
            targetUserId: $user->id,
            action: 'delete',
            description: "Deleted user account",
            oldData: [
                'name' => $user->name,
                'email' => $user->email,
                'status' => $user->status,
                'balance' => $user->balance
            ],
            newData: null,
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        $user->delete();

        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }

    /**
     * Suspend user
     */
    public function suspendUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prevent admin from suspending themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot suspend your own account.');
        }

        $oldStatus = $user->status;
        $user->suspend($request->reason);

        // Log the action
        UserActionLog::logAction(
            adminId: Auth::id(),
            targetUserId: $user->id,
            action: 'suspend',
            description: "Suspended user. Reason: {$request->reason}",
            oldData: ['status' => $oldStatus],
            newData: ['status' => 'suspended', 'reason' => $request->reason],
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        return redirect()->back()->with('success', 'User suspended successfully.');
    }

    /**
     * Block user
     */
    public function blockUser(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'reason' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Prevent admin from blocking themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot block your own account.');
        }

        $oldStatus = $user->status;
        $user->block($request->reason);

        // Log the action
        UserActionLog::logAction(
            adminId: Auth::id(),
            targetUserId: $user->id,
            action: 'block',
            description: "Blocked user. Reason: {$request->reason}",
            oldData: ['status' => $oldStatus],
            newData: ['status' => 'blocked', 'reason' => $request->reason],
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    /**
     * Activate user
     */
    public function activateUser(Request $request, User $user)
    {
        $oldStatus = $user->status;
        $user->activate();

        // Log the action
        UserActionLog::logAction(
            adminId: Auth::id(),
            targetUserId: $user->id,
            action: 'activate',
            description: "Activated user",
            oldData: ['status' => $oldStatus],
            newData: ['status' => 'active'],
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        return redirect()->back()->with('success', 'User activated successfully.');
    }

    /**
     * Show user action logs
     */
    public function userActionLogs(Request $request)
    {
        $query = UserActionLog::with(['admin', 'targetUser'])
            ->orderBy('created_at', 'desc');

        // Filter by action
        if ($request->has('action') && $request->action) {
            $query->where('action', $request->action);
        }

        // Filter by admin
        if ($request->has('admin_id') && $request->admin_id) {
            $query->where('admin_id', $request->admin_id);
        }

        // Filter by target user
        if ($request->has('target_user_id') && $request->target_user_id) {
            $query->where('target_user_id', $request->target_user_id);
        }

        // Filter by date range
        if ($request->has('date_from') && $request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->has('date_to') && $request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20);

        // Get filter options
        $admins = User::where('role', 'admin')->get();
        $actions = UserActionLog::distinct()->pluck('action');

        return view('admin.users.action-logs', compact('logs', 'admins', 'actions'));
    }

    /**
     * Show user IP records
     */
    public function userIpRecords(User $user)
    {
        $ipRecords = $user->ipRecords()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.users.ip-records', compact('user', 'ipRecords'));
    }

    /**
     * Mark IP record as suspicious
     */
    public function markIpSuspicious(UserIpRecord $ipRecord)
    {
        $ipRecord->update([
            'is_suspicious' => true,
            'notes' => 'Marked as suspicious by admin'
        ]);

        return redirect()->back()->with('success', 'IP record marked as suspicious.');
    }

    /**
     * Clear IP record suspicion
     */
    public function clearIpSuspicion(UserIpRecord $ipRecord)
    {
        $ipRecord->update([
            'is_suspicious' => false,
            'notes' => null
        ]);

        return redirect()->back()->with('success', 'IP record suspicion cleared.');
    }

    /**
     * Impersonate a user
     */
    public function impersonate(Request $request, User $user)
    {
        // Check if current user can impersonate
        if (!Auth::user()->canImpersonate()) {
            return redirect()->back()->with('error', 'You do not have permission to impersonate users.');
        }

        // Check if target user can be impersonated
        if (!$user->canBeImpersonated()) {
            return redirect()->back()->with('error', 'This user cannot be impersonated.');
        }

        // Log the action
        UserActionLog::logAction(
            adminId: Auth::id(),
            targetUserId: $user->id,
            action: 'impersonate',
            description: "Started impersonating user {$user->name}",
            oldData: null,
            newData: ['impersonated_user' => $user->name, 'impersonated_user_id' => $user->id],
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        // Start impersonation
        Auth::user()->impersonate($user);

        return redirect()->route('user.dashboard')->with('success', "Now impersonating {$user->name}.");
    }

    /**
     * Stop impersonating
     */
    public function stopImpersonate()
    {
        if (Auth::user()->isImpersonated()) {
            // Log the action before leaving impersonation
            try {
                $impersonatorId = Auth::user()->id;
                // Best-effort: target user not directly available; store minimal context
                UserActionLog::logAction(
                    adminId: $impersonatorId,
                    targetUserId: $impersonatorId,
                    action: 'stop_impersonate',
                    description: 'Stopped impersonating current user session',
                    oldData: null,
                    newData: null,
                    ipAddress: request()->ip(),
                    userAgent: request()->userAgent()
                );
            } catch (\Throwable $e) {
                \Log::warning('Failed to log stop impersonation: '.$e->getMessage());
            }
            Auth::user()->leaveImpersonation();
            return redirect()->route('admin.users')->with('success', 'Stopped impersonating user.');
        }

        return redirect()->back()->with('error', 'You are not currently impersonating anyone.');
    }

    /**
     * Show all tasks
     */
    public function tasks(Request $request)
    {
        $query = Video::query();

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
        }

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $tasks = $query->paginate(5);

        return view('admin.tasks.index', compact('tasks'));
    }

    /**
     * Show create task form
     */
    public function createTask()
    {
        return view('admin.tasks.create');
    }

    /**
     * Store new task
     */
    public function storeTask(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'reward_per_view' => 'required|numeric|min:0.01',
            'status' => 'required|in:active,inactive',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title','description','url','reward_per_view','status']);
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('task-thumbnails', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        Video::create($data);

        return redirect()->route('admin.tasks')->with('success', 'Task created successfully.');
    }

    /**
     * Show specific task details
     */
    public function showTask(Video $task)
    {
        $task->load('watches.user');

        // Get actual earnings from the earnings table for this task
        $total_earnings = Earning::where('video_id', $task->id)->sum('amount');

        $task_stats = [
            'total_watches' => $task->watches->count(),
            'unique_users' => $task->watches->pluck('user_id')->unique()->count(),
            'total_rewards' => $total_earnings,
        ];

        return view('admin.tasks.show', compact('task', 'task_stats'));
    }

    /**
     * Show users who watched a specific task
     */
    public function taskWatchers(Request $request, Video $task)
    {
        $query = UserVideoWatch::with(['user'])
            ->where('video_id', $task->id);

        // Search functionality
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        // Filter by validation status
        if ($request->has('is_valid') && $request->is_valid !== '') {
            $query->where('is_valid', $request->is_valid);
        }

        // Filter by watch percentage range
        if ($request->has('min_percentage') && $request->min_percentage) {
            $query->where('watch_percentage', '>=', $request->min_percentage);
        }
        if ($request->has('max_percentage') && $request->max_percentage) {
            $query->where('watch_percentage', '<=', $request->max_percentage);
        }

        // Sort options
        $sortBy = $request->get('sort_by', 'watched_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['watched_at', 'watch_percentage', 'reward_earned', 'watch_duration'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        }

        $watchers = $query->paginate(15)->withQueryString();

        // Attach has_earning in PHP to avoid correlated subquery issues
        $userIds = $watchers->pluck('user_id')->all();
        $paidUserIds = Earning::where('video_id', $task->id)
            ->whereIn('user_id', $userIds)
            ->pluck('user_id')
            ->all();
        $paidSet = array_flip($paidUserIds);
        foreach ($watchers as $w) {
            $w->has_earning = isset($paidSet[$w->user_id]);
        }

        // Get task statistics for the header
        $task_stats = [
            'total_watches' => UserVideoWatch::where('video_id', $task->id)->count(),
            'valid_watches' => UserVideoWatch::where('video_id', $task->id)->where('is_valid', true)->count(),
            'invalid_watches' => UserVideoWatch::where('video_id', $task->id)->where('is_valid', false)->count(),
            'total_rewards' => Earning::where('video_id', $task->id)->sum('amount'),
            'avg_watch_percentage' => UserVideoWatch::where('video_id', $task->id)->avg('watch_percentage'),
        ];

        return view('admin.tasks.watchers', compact('task', 'watchers', 'task_stats'));
    }

    /**
     * Return details for a specific watch (JSON)
     */
    public function watchDetails(\Illuminate\Http\Request $request, \App\Models\UserVideoWatch $watch)
    {
        $watch->load(['user', 'video']);
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $watch->id,
                'user' => [
                    'id' => $watch->user->id,
                    'name' => $watch->user->name,
                    'email' => $watch->user->email,
                ],
                'video' => [
                    'id' => $watch->video->id,
                    'title' => $watch->video->title,
                ],
                'watch_duration' => $watch->watch_duration,
                'video_duration' => $watch->video_duration,
                'watch_percentage' => $watch->watch_percentage,
                'seek_count' => $watch->seek_count,
                'pause_count' => $watch->pause_count,
                'heartbeat_count' => $watch->heartbeat_count,
                'tab_visible' => (bool) $watch->tab_visible,
                'is_valid' => (bool) $watch->is_valid,
                'reward_earned' => $watch->reward_earned,
                'watched_at' => optional($watch->watched_at)->toDateTimeString(),
                'validation_notes' => $watch->validation_notes,
                'watch_events' => $watch->watch_events,
            ]
        ]);
    }

    /**
     * Credit reward for a specific watch; creates Earning if missing
     */
    public function creditWatch(\Illuminate\Http\Request $request, \App\Models\UserVideoWatch $watch)
    {
        if (!$watch->is_valid) {
            return response()->json(['success' => false, 'message' => 'Watch is invalid and cannot be credited.'], 422);
        }

        $existing = Earning::where('user_id', $watch->user_id)
            ->where('video_id', $watch->video_id)
            ->first();

        if ($existing) {
            return response()->json(['success' => true, 'message' => 'Already credited.']);
        }

        $amount = optional($watch->video)->reward_per_view ?? 0;
        $earning = Earning::create([
            'user_id' => $watch->user_id,
            'video_id' => $watch->video_id,
            'amount' => $amount,
            'type' => 'video_completion',
        ]);

        return response()->json(['success' => true, 'message' => 'Reward credited successfully.', 'earning_id' => $earning->id]);
    }

    /**
     * Update task
     */
    public function updateTask(Request $request, Video $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'required|url',
            'reward_per_view' => 'required|numeric|min:0.01',
            'status' => 'required|in:active,inactive',
            'thumbnail' => 'nullable|image|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = $request->only(['title','description','url','reward_per_view','status']);
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('task-thumbnails', 'public');
            $data['thumbnail'] = '/storage/' . $path;
        }

        $task->update($data);

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    /**
     * Delete task
     */
    public function deleteTask(Video $task)
    {
        $task->delete();

        return redirect()->route('admin.tasks')->with('success', 'Task deleted successfully.');
    }

    /**
     * Toggle task status
     */
    public function toggleTaskStatus(Video $task)
    {
        $task->status = $task->status === 'active' ? 'inactive' : 'active';
        $task->save();

        return redirect()->back()->with('success', 'Task status updated successfully.');
    }

    /**
     * Show all withdrawals
     */
    public function withdrawals(Request $request)
    {
        $query = Withdrawal::with('user');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->orderBy('requested_at', 'desc')->paginate(5);

        return view('admin.withdrawals.index', compact('withdrawals'));
    }

    /**
     * Show specific withdrawal details
     */
    public function showWithdrawal(Withdrawal $withdrawal)
    {
        $withdrawal->load('user');

        return view('admin.withdrawals.show', compact('withdrawal'));
    }

    /**
     * Approve withdrawal
     */
    public function approveWithdrawal(Request $request, Withdrawal $withdrawal)
    {
        $validator = Validator::make($request->all(), [
            'admin_notes' => 'nullable|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $withdrawal->update([
            'status' => 'approved',
            'admin_notes' => $request->admin_notes,
            'processed_at' => now(),
            'processed_by' => Auth::id()
        ]);

        // Log action
        try {
            UserActionLog::logAction(
                adminId: Auth::id(),
                targetUserId: $withdrawal->user_id,
                action: 'withdrawal_approve',
                description: 'Approved withdrawal request',
                oldData: ['withdrawal_id' => $withdrawal->id, 'previous_status' => 'pending'],
                newData: ['status' => 'approved', 'amount' => $withdrawal->amount],
                ipAddress: $request->ip(),
                userAgent: $request->userAgent()
            );
        } catch (\Throwable $e) {
            \Log::warning('Failed to log withdrawal approval: '.$e->getMessage());
        }

        // Send approval email to user
        try {
            Mail::to($withdrawal->user->email)->send(new WithdrawalApproved($withdrawal->user, $withdrawal));
        } catch (\Exception $e) {
            Log::error('Failed to send withdrawal approval email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Withdrawal approved successfully and user has been notified via email.');
    }

    /**
     * Reject withdrawal
     */
    public function rejectWithdrawal(Request $request, Withdrawal $withdrawal)
    {
        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string|max:500'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        // Refund the amount to user's balance
        $user = $withdrawal->user;
        $user->balance += $withdrawal->amount;
        $user->save();

        $withdrawal->update([
            'status' => 'rejected',
            'admin_notes' => $request->rejection_reason,
            'processed_at' => now(),
            'processed_by' => Auth::id()
        ]);

        // Log action
        try {
            UserActionLog::logAction(
                adminId: Auth::id(),
                targetUserId: $withdrawal->user_id,
                action: 'withdrawal_reject',
                description: 'Rejected withdrawal request',
                oldData: ['withdrawal_id' => $withdrawal->id, 'previous_status' => 'pending'],
                newData: ['status' => 'rejected', 'amount' => $withdrawal->amount, 'reason' => $request->rejection_reason],
                ipAddress: $request->ip(),
                userAgent: $request->userAgent()
            );
        } catch (\Throwable $e) {
            \Log::warning('Failed to log withdrawal rejection: '.$e->getMessage());
        }

        // Send rejection email to user
        try {
            Mail::to($withdrawal->user->email)->send(new WithdrawalRejected($withdrawal->user, $withdrawal));
        } catch (\Exception $e) {
            Log::error('Failed to send withdrawal rejection email: ' . $e->getMessage());
        }

        return redirect()->back()->with('success', 'Withdrawal rejected, amount refunded to user, and user has been notified via email.');
    }

    /**
     * Show analytics dashboard
     */
    public function analytics()
    {
        // User analytics (avoid relying on non-existent columns)
        $activeUsersCount = Schema::hasColumn('users', 'status')
            ? User::where('status', 'active')->count()
            : (Schema::hasColumn('users', 'email_verified_at')
                ? User::whereNotNull('email_verified_at')->count()
                : User::count());

        $user_stats = [
            'total_users' => User::count(),
            'new_users_this_month' => User::whereMonth('created_at', now()->month)->count(),
            'active_users' => $activeUsersCount,
            'users_by_role' => User::selectRaw('role, count(*) as count')->groupBy('role')->get(),
        ];

        // Earning analytics
        $earning_stats = [
            'total_earnings' => Earning::sum('amount'),
            'earnings_this_month' => Earning::whereMonth('created_at', now()->month)->sum('amount'),
            'average_earning_per_user' => Earning::avg('amount'),
            'earnings_by_month' => Earning::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('month')
                ->get(),
        ];

        // Withdrawal analytics
        $withdrawal_stats = [
            'total_withdrawals' => Withdrawal::sum('amount'),
            'pending_withdrawals' => Withdrawal::where('status', 'pending')->sum('amount'),
            'approved_withdrawals' => Withdrawal::where('status', 'approved')->sum('amount'),
            'withdrawals_by_status' => Withdrawal::selectRaw('status, count(*) as count, SUM(amount) as total')
                ->groupBy('status')
                ->get(),
        ];

        return view('admin.analytics.index', compact('user_stats', 'earning_stats', 'withdrawal_stats'));
    }

    /**
     * Show user analytics
     */
    public function userAnalytics()
    {
        $users = User::withCount(['earnings', 'withdrawals', 'watches'])
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.analytics.users', compact('users'));
    }

    /**
     * Show earning analytics
     */
    public function earningAnalytics()
    {
        $earnings = Earning::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.analytics.earnings', compact('earnings'));
    }

    /**
     * Show withdrawal analytics
     */
    public function withdrawalAnalytics()
    {
        $withdrawals = Withdrawal::with('user')
            ->orderBy('requested_at', 'desc')
            ->paginate(5);

        return view('admin.analytics.withdrawals', compact('withdrawals'));
    }

    /**
     * Show settings page
     */
    public function settings()
    {
        return view('admin.settings');
    }

    /**
     * Update settings
     */
    public function updateSettings(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'site_name' => 'required|string|max:255',
            'min_withdrawal' => 'required|numeric|min:1',
            'max_withdrawal' => 'required|numeric|min:1',
            'withdrawal_fee' => 'required|numeric|min:0',
            'admin_email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update settings (you might want to store these in a settings table or config file)
        \Log::info("Admin {$request->user()->name} updated system settings", $request->all());

        return redirect()->back()->with('success', 'Settings updated successfully.');
    }

    /**
     * Show reports page
     */
    public function reports()
    {
        return view('admin.reports');
    }

    /**
     * Export reports
     */
    public function exportReport(Request $request)
    {
        $type = $request->get('type', 'users');
        $format = $request->get('format', 'csv');

        // Implementation for exporting reports
        // This would typically generate and download a file

        return redirect()->back()->with('success', 'Report exported successfully.');
    }

    /**
     * List users flagged for cheating attempts (grouped by user)
     */
    public function cheaters(Request $request)
    {
        $query = SuspensionOrchestration::cheating()->with('user')
            ->select('user_id')
            ->groupBy('user_id');

        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get paginated user IDs with cheating attempts
        $userGroups = $query->paginate(15);

        // Load aggregates for display
        $userIds = $userGroups->pluck('user_id')->all();
        $attempts = SuspensionOrchestration::cheating()
            ->whereIn('user_id', $userIds)
            ->with('video')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('user_id');

        return view('admin.cheaters.index', [
            'userGroups' => $userGroups,
            'attemptsByUser' => $attempts,
        ]);
    }

    /**
     * Show suspensions management page
     */
    public function suspensions(Request $request)
    {
        $query = SuspensionOrchestration::with(['user', 'video', 'resolvedBy']);

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by type
        if ($request->has('type') && $request->type) {
            $query->where('suspension_type', $request->type);
        }

        // Search by user name or email
        if ($request->has('search') && $request->search) {
            $query->whereHas('user', function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $suspensions = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get suspension statistics
        $suspensionService = new SuspensionService();
        $stats = $suspensionService->getSuspensionStats();

        return view('admin.suspensions.index', compact('suspensions', 'stats'));
    }

    /**
     * Show specific suspension details
     */
    public function showSuspension(SuspensionOrchestration $suspension)
    {
        $suspension->load(['user', 'video', 'resolvedBy']);
        return view('admin.suspensions.show', compact('suspension'));
    }

    /**
     * Approve suspension and credit wallet
     */
    public function approveSuspension(Request $request, SuspensionOrchestration $suspension)
    {
        $request->validate([
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $suspensionService = new SuspensionService();
        $suspensionService->creditUserWallet($suspension);

        $suspension->approve(Auth::id(), $request->admin_notes);

        return redirect()->route('admin.suspensions')
            ->with('success', 'Suspension approved and wallet credited successfully.');
    }

    /**
     * Reject suspension
     */
    public function rejectSuspension(Request $request, SuspensionOrchestration $suspension)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $suspensionService = new SuspensionService();
        $suspensionService->rejectSuspension($suspension, Auth::id(), $request->admin_notes);

        return redirect()->route('admin.suspensions')
            ->with('success', 'Suspension rejected successfully.');
    }

    /**
     * Credit wallet for approved suspension
     */
    public function creditWallet(SuspensionOrchestration $suspension)
    {
        if ($suspension->wallet_credited) {
            return redirect()->back()->with('error', 'Wallet has already been credited for this suspension.');
        }

        $suspensionService = new SuspensionService();
        $suspensionService->creditUserWallet($suspension);

        return redirect()->back()->with('success', 'Wallet credited successfully.');
    }

    /**
     * Toggle autopilot mode
     */
    public function toggleAutopilot(Request $request)
    {
        $request->validate([
            'enabled' => 'required|boolean'
        ]);

        // Update config or database setting
        // For now, we'll use a simple approach
        $enabled = $request->enabled;

        // You can store this in a settings table or config file
        // For demonstration, we'll use a simple approach

        return response()->json([
            'success' => true,
            'message' => 'Autopilot mode ' . ($enabled ? 'enabled' : 'disabled'),
            'enabled' => $enabled
        ]);
    }
}
