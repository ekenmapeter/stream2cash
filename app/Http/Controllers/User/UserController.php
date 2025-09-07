<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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

        // Mock data - replace with actual data from database
        $stats = [
            'available_tasks' => 34,
            'completed_tasks' => 4,
            'withdrawals' => 15,
            'wallet_balance' => 15000
        ];

        $recent_history = [
            [
                'name' => 'Join our Patreon',
                'description' => 'Join our Patreon channel to get design',
                'amount' => 100,
                'status' => 'Completed',
                'date' => '19/08/2025'
            ],
            [
                'name' => 'Video Watch Task',
                'description' => 'Watch 2-minute video and earn',
                'amount' => 50,
                'status' => 'Completed',
                'date' => '18/08/2025'
            ],
            [
                'name' => 'Survey Task',
                'description' => 'Complete market research survey',
                'amount' => 75,
                'status' => 'Pending',
                'date' => '17/08/2025'
            ]
        ];

        $recent_tasks = [
            [
                'title' => 'Video trash 2 min watch time generate',
                'description' => 'Join our Patreon channel to getce AE files and design atreon.com',
                'amount' => 100,
                'status' => 'Not Completed',
                'thumbnail' => 'https://placehold.co/80x80/0000FF/FFFFFF?text=Video'
            ],
            [
                'title' => 'Survey completion task',
                'description' => 'Complete a quick survey about your preferences',
                'amount' => 50,
                'status' => 'Completed',
                'thumbnail' => 'https://placehold.co/80x80/00FF00/FFFFFF?text=Survey'
            ]
        ];

        return view('user.dashboard', compact('stats', 'recent_history', 'recent_tasks'));
    }

    /**
     * Show the user wallet.
     */
    public function wallet()
    {
        $user = Auth::user();

        // Mock data - replace with actual data from database
        $wallet_data = [
            'balance' => 15000,
            'pending' => 500,
            'total_earned' => 25000,
            'total_withdrawn' => 10000
        ];

        return view('user.wallet', compact('wallet_data'));
    }

    /**
     * Show available tasks.
     */
    public function tasks()
    {
        $user = Auth::user();

        // Mock data - replace with actual data from database
        $tasks = [
            [
                'id' => 1,
                'title' => 'Video Watch Task',
                'description' => 'Watch a 2-minute video and earn money',
                'amount' => 100,
                'status' => 'Available',
                'thumbnail' => 'https://placehold.co/300x200/0000FF/FFFFFF?text=Video'
            ],
            [
                'id' => 2,
                'title' => 'Survey Task',
                'description' => 'Complete a market research survey',
                'amount' => 75,
                'status' => 'Available',
                'thumbnail' => 'https://placehold.co/300x200/00FF00/FFFFFF?text=Survey'
            ]
        ];

        return view('user.tasks', compact('tasks'));
    }

    /**
     * Show user profile.
     */
    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    /**
     * Show withdrawal page.
     */
    public function withdrawal()
    {
        $user = Auth::user();

        // Mock data - replace with actual data from database
        $withdrawal_data = [
            'balance' => 15000,
            'min_withdrawal' => 1000,
            'withdrawal_methods' => ['Bank Transfer', 'PayPal', 'Mobile Money']
        ];

        return view('user.withdrawal', compact('withdrawal_data'));
    }
}
