<!-- Withdrawal Management Index -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Withdrawal Management</h1>
          <p class="text-gray-600">Review and approve withdrawal requests</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
      </div>

      <!-- Filter -->
      <div class="bg-gray-50 p-4 rounded-xl mb-6">
        <form method="GET" class="flex gap-4">
          <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">All Status</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
          </select>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-filter mr-2"></i>Filter
          </button>
        </form>
      </div>

      <!-- Withdrawals Table -->
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Payment Method</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($withdrawals as $withdrawal)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($withdrawal->user->name, 0, 1)) }}
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ $withdrawal->user->name }}</div>
                      <div class="text-sm text-gray-500">{{ $withdrawal->user->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                  ₪{{ number_format($withdrawal->amount, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  {{ ucfirst($withdrawal->payment_method ?? 'Bank Transfer') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                    $statusColors = [
                      'pending' => 'bg-yellow-100 text-yellow-800',
                      'approved' => 'bg-green-100 text-green-800',
                      'rejected' => 'bg-red-100 text-red-800'
                    ];
                  @endphp
                  <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$withdrawal->status] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($withdrawal->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ optional($withdrawal->requested_at)->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <a href="{{ route('admin.withdrawals.show', $withdrawal) }}" class="text-blue-600 hover:text-blue-900">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    @if($withdrawal->status === 'pending')
                      <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-green-600 hover:text-green-900"
                                onclick="return confirm('Are you sure you want to approve this withdrawal?')">
                          <i class="fa-solid fa-check"></i>
                        </button>
                      </form>
                      <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}" class="inline">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="text-red-600 hover:text-red-900"
                                onclick="return confirm('Are you sure you want to reject this withdrawal?')">
                          <i class="fa-solid fa-times"></i>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No withdrawals found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($withdrawals->hasPages())
        <div class="mt-6">
          {{ $withdrawals->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </section>
</div>

@endsection
