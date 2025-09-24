<!-- Analytics Dashboard -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-2">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Analytics Dashboard</h1>
          <p class="text-gray-600">Platform performance and user insights</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
      </div>

      <!-- Info Matrix -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Total Users</div>
            <div class="text-2xl font-bold text-gray-800">{{ number_format($user_stats['total_users']) }}</div>
          </div>
          <i class="fa-solid fa-users text-blue-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Active Users</div>
            <div class="text-2xl font-bold text-gray-800">{{ number_format($user_stats['active_users']) }}</div>
          </div>
          <i class="fa-solid fa-user-check text-green-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">New This Month</div>
            <div class="text-2xl font-bold text-gray-800">{{ number_format($user_stats['new_users_this_month']) }}</div>
          </div>
          <i class="fa-solid fa-user-plus text-purple-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Total Earnings</div>
            <div class="text-2xl font-bold text-gray-800">${{ number_format($earning_stats['total_earnings']) }}</div>
          </div>
          <i class="fa-solid fa-dollar-sign text-amber-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Earnings This Month</div>
            <div class="text-2xl font-bold text-gray-800">${{ number_format($earning_stats['earnings_this_month']) }}</div>
          </div>
          <i class="fa-solid fa-calendar text-blue-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Avg per User</div>
            <div class="text-2xl font-bold text-gray-800">${{ number_format($earning_stats['average_earning_per_user'], 2) }}</div>
          </div>
          <i class="fa-solid fa-chart-line text-fuchsia-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Total Withdrawals</div>
            <div class="text-2xl font-bold text-gray-800">${{ number_format($withdrawal_stats['total_withdrawals']) }}</div>
          </div>
          <i class="fa-solid fa-money-bill-transfer text-emerald-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Pending Withdrawals</div>
            <div class="text-2xl font-bold text-gray-800">${{ number_format($withdrawal_stats['pending_withdrawals']) }}</div>
          </div>
          <i class="fa-solid fa-clock text-red-600 text-2xl"></i>
        </div>
        <div class="bg-white border rounded-xl p-5 flex items-center justify-between">
          <div>
            <div class="text-sm text-gray-500">Approved Withdrawals</div>
            <div class="text-2xl font-bold text-gray-800">${{ number_format($withdrawal_stats['approved_withdrawals']) }}</div>
          </div>
          <i class="fa-solid fa-check-circle text-green-600 text-2xl"></i>
        </div>
      </div>

      <!-- Analytics Navigation -->
      <div class="bg-gray-50 p-4 rounded-xl mb-8">
        <div class="flex flex-wrap gap-4">
          <a href="{{ route('admin.analytics') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Overview</a>
          <a href="{{ route('admin.analytics.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">User Analytics</a>
          <a href="{{ route('admin.analytics.earnings') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">Earning Analytics</a>
          <a href="{{ route('admin.analytics.withdrawals') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">Withdrawal Analytics</a>
        </div>
      </div>

      <!-- Earnings by Month (Live) -->
      <div class="bg-white rounded-2xl shadow p-6 mb-8">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold">Earnings by Month</h3>
          <span class="text-xs text-gray-500">Live</span>
        </div>
        <canvas id="earningsChart" height="90"></canvas>
      </div>

      <!-- User Statistics -->
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">User Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-blue-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-users text-3xl text-blue-600 mb-2"></i>
            <div class="text-2xl font-bold text-blue-800">{{ number_format($user_stats['total_users']) }}</div>
            <div class="text-sm text-blue-600">Total Users</div>
          </div>
          <div class="bg-green-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-user-plus text-3xl text-green-600 mb-2"></i>
            <div class="text-2xl font-bold text-green-800">{{ number_format($user_stats['new_users_this_month']) }}</div>
            <div class="text-sm text-green-600">New This Month</div>
          </div>
          <div class="bg-purple-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-user-check text-3xl text-purple-600 mb-2"></i>
            <div class="text-2xl font-bold text-purple-800">{{ number_format($user_stats['active_users']) }}</div>
            <div class="text-sm text-purple-600">Active Users</div>
          </div>
          <div class="bg-yellow-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-crown text-3xl text-yellow-600 mb-2"></i>
            <div class="text-2xl font-bold text-yellow-800">{{ $user_stats['users_by_role']->where('role', 'admin')->first()->count ?? 0 }}</div>
            <div class="text-sm text-yellow-600">Admins</div>
          </div>
        </div>
      </div>



      <!-- Earning Statistics -->
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Earning Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-green-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-dollar-sign text-3xl text-green-600 mb-2"></i>
            <div class="text-2xl font-bold text-green-800">${{ number_format($earning_stats['total_earnings']) }}</div>
            <div class="text-sm text-green-600">Total Earnings</div>
          </div>
          <div class="bg-blue-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-calendar text-3xl text-blue-600 mb-2"></i>
            <div class="text-2xl font-bold text-blue-800">${{ number_format($earning_stats['earnings_this_month']) }}</div>
            <div class="text-sm text-blue-600">This Month</div>
          </div>
          <div class="bg-purple-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-chart-line text-3xl text-purple-600 mb-2"></i>
            <div class="text-2xl font-bold text-purple-800">${{ number_format($earning_stats['average_earning_per_user'], 2) }}</div>
            <div class="text-sm text-purple-600">Avg per User</div>
          </div>
          <div class="bg-yellow-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-trending-up text-3xl text-yellow-600 mb-2"></i>
            <div class="text-2xl font-bold text-yellow-800">{{ $earning_stats['earnings_by_month']->count() }}</div>
            <div class="text-sm text-yellow-600">Active Months</div>
          </div>
        </div>
      </div>

      <!-- Withdrawal Statistics -->
      <div class="mb-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Withdrawal Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-yellow-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-money-bill-transfer text-3xl text-yellow-600 mb-2"></i>
            <div class="text-2xl font-bold text-yellow-800">${{ number_format($withdrawal_stats['total_withdrawals']) }}</div>
            <div class="text-sm text-yellow-600">Total Withdrawals</div>
          </div>
          <div class="bg-red-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-clock text-3xl text-red-600 mb-2"></i>
            <div class="text-2xl font-bold text-red-800">${{ number_format($withdrawal_stats['pending_withdrawals']) }}</div>
            <div class="text-sm text-red-600">Pending</div>
          </div>
          <div class="bg-green-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-check-circle text-3xl text-green-600 mb-2"></i>
            <div class="text-2xl font-bold text-green-800">${{ number_format($withdrawal_stats['approved_withdrawals']) }}</div>
            <div class="text-sm text-green-600">Approved</div>
          </div>
          <div class="bg-blue-100 p-6 rounded-xl text-center">
            <i class="fa-solid fa-percentage text-3xl text-blue-600 mb-2"></i>
            <div class="text-2xl font-bold text-blue-800">
              {{ $withdrawal_stats['total_withdrawals'] > 0 ? number_format(($withdrawal_stats['approved_withdrawals'] / $withdrawal_stats['total_withdrawals']) * 100, 1) : 0 }}%
            </div>
            <div class="text-sm text-blue-600">Approval Rate</div>
          </div>
        </div>
      </div>

      <!-- Charts Section -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Users by Role</h3>
          <div class="space-y-2">
            @foreach($user_stats['users_by_role'] as $role)
              <div class="flex justify-between items-center">
                <span class="capitalize">{{ $role->role }}</span>
                <span class="font-semibold">{{ $role->count }}</span>
              </div>
            @endforeach
          </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Withdrawals by Status</h3>
          <div class="space-y-2">
            @foreach($withdrawal_stats['withdrawals_by_status'] as $status)
              <div class="flex justify-between items-center">
                <span class="capitalize">{{ $status->status }}</span>
                <div class="text-right">
                  <div class="font-semibold">{{ $status->count }}</div>
                  <div class="text-sm text-gray-600">${{ number_format($status->total) }}</div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </section>
</div>

@endsection
