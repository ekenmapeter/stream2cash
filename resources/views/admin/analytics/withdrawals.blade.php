@extends('admin.layouts.app')

@section('content')
<div class="pt-4 px-4">
  <section class="flex justify-center items-center py-8 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Withdrawal Analytics</h1>
          <p class="text-gray-600">Withdrawals with user context</p>
        </div>
        <a href="{{ route('admin.analytics') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Overview
        </a>
      </div>

      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Requested</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($withdrawals as $withdrawal)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="text-sm font-medium text-gray-900">{{ $withdrawal->user->name }}</div>
                  <div class="text-sm text-gray-500">{{ $withdrawal->user->email }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">₪{{ number_format($withdrawal->amount, 2) }}</td>
                <td class="px-6 py-4 whitespace-nowrap text-sm">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $withdrawal->status === 'approved' ? 'bg-green-100 text-green-800' : ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($withdrawal->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ optional($withdrawal->requested_at)->format('M d, Y H:i') }}</td>
              </tr>
            @empty
              <tr>
                <td colspan="4" class="px-6 py-4 text-center text-gray-500">No withdrawals found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      @if($withdrawals->hasPages())
        <div class="mt-6">
          {{ $withdrawals->links() }}
        </div>
      @endif

    </div>
  </section>
</div>
@endsection


