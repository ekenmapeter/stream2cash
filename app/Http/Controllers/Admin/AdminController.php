<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Video;
use App\Models\Withdrawal;
use App\Models\Earning;
use App\Models\UserIpRecord;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

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

        // Log the balance change
        \Log::info("Admin {$request->user()->name} updated user {$user->name} balance from {$old_balance} to {$request->balance}. Reason: {$request->reason}");

        return redirect()->back()->with('success', 'User balance updated successfully.');
    }

    /**
     * Delete user
     */
    public function deleteUser(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

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

        $user->suspend($request->reason);

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

        $user->block($request->reason);

        return redirect()->back()->with('success', 'User blocked successfully.');
    }

    /**
     * Activate user
     */
    public function activateUser(User $user)
    {
        $user->activate();

        return redirect()->back()->with('success', 'User activated successfully.');
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
    public function impersonate(User $user)
    {
        // Check if current user can impersonate
        if (!Auth::user()->canImpersonate()) {
            return redirect()->back()->with('error', 'You do not have permission to impersonate users.');
        }

        // Check if target user can be impersonated
        if (!$user->canBeImpersonated()) {
            return redirect()->back()->with('error', 'This user cannot be impersonated.');
        }

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
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Video::create($request->all());

        return redirect()->route('admin.tasks')->with('success', 'Task created successfully.');
    }

    /**
     * Show specific task details
     */
    public function showTask(Video $task)
    {
        $task->load('watches.user');

        $task_stats = [
            'total_watches' => $task->watches->count(),
            'unique_users' => $task->watches->pluck('user_id')->unique()->count(),
            'total_rewards' => $task->watches->sum('reward_amount'),
        ];

        return view('admin.tasks.show', compact('task', 'task_stats'));
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
            'status' => 'required|in:active,inactive'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $task->update($request->all());

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

        $withdrawals = $query->latest()->paginate(5);

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

        return redirect()->back()->with('success', 'Withdrawal approved successfully.');
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

        return redirect()->back()->with('success', 'Withdrawal rejected and amount refunded to user.');
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
}
