<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function dashboard()
    {
        $user = Auth::user();

        // Mock admin data
        $admin_stats = [
            'total_users' => 1250,
            'active_tasks' => 45,
            'total_earnings' => 125000,
            'pending_withdrawals' => 12
        ];

        return view('admin.dashboard', compact('admin_stats'));
    }
}
