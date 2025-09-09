@extends('admin.layouts.app')

@section('content')
  <div class="pt-4 px-4">

  <!-- Admin Dashboard Header -->
  <section class="flex justify-center items-center py-14 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-2">
      <div class="text-center mb-8">
        <i class="fa-solid fa-crown text-6xl text-yellow-500 mb-4"></i>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Admin Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ Auth::user()->name }}! Manage your platform.</p>
      </div>

      <!-- Admin Stats -->
      <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-blue-100 p-6 rounded-xl text-center">
          <i class="fa-solid fa-users text-3xl text-blue-600 mb-2"></i>
          <div class="text-2xl font-bold text-blue-800">{{ number_format($admin_stats['total_users']) }}</div>
          <div class="text-sm text-blue-600">Total Users</div>
        </div>
        <div class="bg-green-100 p-6 rounded-xl text-center">
          <i class="fa-solid fa-tasks text-3xl text-green-600 mb-2"></i>
          <div class="text-2xl font-bold text-green-800">{{ $admin_stats['active_tasks'] }}</div>
          <div class="text-sm text-green-600">Active Tasks</div>
        </div>
        <div class="bg-yellow-100 p-6 rounded-xl text-center">
          <i class="fa-solid fa-dollar-sign text-3xl text-yellow-600 mb-2"></i>
          <div class="text-2xl font-bold text-yellow-800">₦ {{ number_format($admin_stats['total_earnings']) }}</div>
          <div class="text-sm text-yellow-600">Total Earnings</div>
        </div>
        <div class="bg-red-100 p-6 rounded-xl text-center">
          <i class="fa-solid fa-clock text-3xl text-red-600 mb-2"></i>
          <div class="text-2xl font-bold text-red-800">{{ $admin_stats['pending_withdrawals'] }}</div>
          <div class="text-sm text-red-600">Pending Withdrawals</div>
        </div>
      </div>

      <!-- Quick Actions -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <a href="{{ route('admin.users') }}" class="bg-blue-700 hover:bg-blue-600 text-white p-6 rounded-xl flex items-center justify-between transition-colors">
          <div>
            <div class="font-semibold text-lg">Manage Users</div>
            <div class="text-sm text-blue-200">View and manage user accounts</div>
          </div>
          <i class="fa-solid fa-users text-2xl"></i>
        </a>

        <a href="{{ route('admin.tasks') }}" class="bg-green-700 hover:bg-green-600 text-white p-6 rounded-xl flex items-center justify-between transition-colors">
          <div>
            <div class="font-semibold text-lg">Manage Tasks</div>
            <div class="text-sm text-green-200">Create and manage earning tasks</div>
          </div>
          <i class="fa-solid fa-tasks text-2xl"></i>
        </a>

        <a href="{{ route('admin.withdrawals') }}" class="bg-yellow-700 hover:bg-yellow-600 text-white p-6 rounded-xl flex items-center justify-between transition-colors">
          <div>
            <div class="font-semibold text-lg">Withdrawals</div>
            <div class="text-sm text-yellow-200">Review and approve withdrawals</div>
          </div>
          <i class="fa-solid fa-money-bill-transfer text-2xl"></i>
        </a>

        <a href="{{ route('admin.analytics') }}" class="bg-purple-700 hover:bg-purple-600 text-white p-6 rounded-xl flex items-center justify-between transition-colors">
          <div>
            <div class="font-semibold text-lg">Analytics</div>
            <div class="text-sm text-purple-200">View platform analytics</div>
          </div>
          <i class="fa-solid fa-chart-line text-2xl"></i>
        </a>

        <a href="{{ route('admin.settings.index') }}" class="bg-gray-700 hover:bg-gray-600 text-white p-6 rounded-xl flex items-center justify-between transition-colors">
          <div>
            <div class="font-semibold text-lg">Settings</div>
            <div class="text-sm text-gray-200">Configure platform settings</div>
          </div>
          <i class="fa-solid fa-cog text-2xl"></i>
        </a>

        <a href="{{ route('admin.reports') }}" class="bg-indigo-700 hover:bg-indigo-600 text-white p-6 rounded-xl flex items-center justify-between transition-colors">
          <div>
            <div class="font-semibold text-lg">Reports</div>
            <div class="text-sm text-indigo-200">Generate and export reports</div>
          </div>
          <i class="fa-solid fa-file-export text-2xl"></i>
        </a>
      </div>

      <!-- Recent Activity -->
      <div class="mt-8">
        <h3 class="text-xl font-semibold mb-4">Recent Activity</h3>
        <div class="bg-gray-50 p-4 rounded-xl">
          <div class="space-y-3">
            @if($recent_users->count() > 0)
              @foreach($recent_users->take(3) as $user)
                <div class="flex items-center justify-between">
                  <span class="text-sm">New user registration: {{ $user->name }}</span>
                  <span class="text-xs text-gray-500">{{ $user->created_at->diffForHumans() }}</span>
                </div>
              @endforeach
            @endif

            @if($recent_withdrawals->count() > 0)
              @foreach($recent_withdrawals->take(2) as $withdrawal)
                <div class="flex items-center justify-between">
                  <span class="text-sm">Withdrawal request: ₪{{ number_format($withdrawal->amount) }} - {{ $withdrawal->user->name }}</span>
                  <span class="text-xs text-gray-500">{{ optional($withdrawal->requested_at)->diffForHumans() }}</span>
                </div>
              @endforeach
            @endif

            @if($recent_earnings->count() > 0)
              @foreach($recent_earnings->take(2) as $earning)
                <div class="flex items-center justify-between">
                  <span class="text-sm">Task completed: ₦ {{ number_format($earning->amount) }} - {{ $earning->user->name }}</span>
                  <span class="text-xs text-gray-500">{{ $earning->created_at->diffForHumans() }}</span>
                </div>
              @endforeach
            @endif
          </div>
        </div>
      </div>
    </div>
  </section>

  </div>
@endsection
