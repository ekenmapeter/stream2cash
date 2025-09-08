<!-- Withdrawal Details View -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Withdrawal Details</h1>
          <p class="text-gray-600">Review withdrawal request #{{ $withdrawal->id }}</p>
        </div>
        <a href="{{ route('admin.withdrawals') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Withdrawals
        </a>
      </div>

      <!-- Withdrawal Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">User Information</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Name:</span>
              <span class="font-medium">{{ $withdrawal->user->name }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Email:</span>
              <span class="font-medium">{{ $withdrawal->user->email }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Current Balance:</span>
              <span class="font-medium text-green-600">₪{{ number_format($withdrawal->user->balance, 2) }}</span>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Withdrawal Details</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Amount:</span>
              <span class="font-medium text-blue-600">₪{{ number_format($withdrawal->amount, 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Payment Method:</span>
              <span class="font-medium">{{ ucfirst($withdrawal->payment_method ?? 'Bank Transfer') }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Status:</span>
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
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Requested:</span>
              <span class="font-medium">{{ optional($withdrawal->requested_at)->format('M d, Y H:i') }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Payment Details -->
      @if($withdrawal->payment_details)
        <div class="bg-gray-50 p-6 rounded-xl mb-8">
          <h3 class="text-lg font-semibold mb-4">Payment Details</h3>
          <div class="bg-white p-4 rounded-lg">
            <pre class="whitespace-pre-wrap text-sm">{{ $withdrawal->payment_details }}</pre>
          </div>
        </div>
      @endif

      <!-- Admin Notes -->
      @if($withdrawal->admin_notes)
        <div class="bg-gray-50 p-6 rounded-xl mb-8">
          <h3 class="text-lg font-semibold mb-4">Admin Notes</h3>
          <div class="bg-white p-4 rounded-lg">
            <p class="text-gray-700">{{ $withdrawal->admin_notes }}</p>
          </div>
        </div>
      @endif

      <!-- Actions -->
      @if($withdrawal->status === 'pending')
        <div class="bg-yellow-50 p-6 rounded-xl mb-8">
          <h3 class="text-lg font-semibold mb-4">Process Withdrawal</h3>

          <!-- Approve Form -->
          <form method="POST" action="{{ route('admin.withdrawals.approve', $withdrawal) }}" class="mb-4">
            @csrf
            @method('PATCH')
            <div class="mb-4">
              <label for="admin_notes" class="block text-sm font-medium text-gray-700 mb-2">Admin Notes (Optional)</label>
              <textarea id="admin_notes" name="admin_notes" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        placeholder="Add any notes about this approval..."></textarea>
            </div>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors"
                    onclick="return confirm('Are you sure you want to approve this withdrawal?')">
              <i class="fa-solid fa-check mr-2"></i>Approve Withdrawal
            </button>
          </form>

          <!-- Reject Form -->
          <form method="POST" action="{{ route('admin.withdrawals.reject', $withdrawal) }}">
            @csrf
            @method('PATCH')
            <div class="mb-4">
              <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">Rejection Reason *</label>
              <textarea id="rejection_reason" name="rejection_reason" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent"
                        placeholder="Please provide a reason for rejection..." required></textarea>
            </div>
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors"
                    onclick="return confirm('Are you sure you want to reject this withdrawal? The amount will be refunded to the user.')">
              <i class="fa-solid fa-times mr-2"></i>Reject Withdrawal
            </button>
          </form>
        </div>
      @else
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Withdrawal Status</h3>
          <p class="text-gray-600">
            This withdrawal has been {{ $withdrawal->status }}.
            @if($withdrawal->processed_at)
              Processed on {{ $withdrawal->processed_at->format('M d, Y H:i') }}.
            @endif
          </p>
        </div>
      @endif

    </div>
  </section>
</div>

@endsection
