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
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Email:</span>
              <div class="flex items-center space-x-2">
              <span class="font-medium">{{ $withdrawal->user->email }}</span>
                <button onclick="copyToClipboard('{{ $withdrawal->user->email }}', this)"
                        class="text-blue-600 hover:text-blue-800 transition-colors"
                        title="Copy email">
                  <i class="fa-solid fa-copy text-sm"></i>
                </button>
              </div>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Current Balance:</span>
              <span class="font-medium text-green-600">${{ number_format($withdrawal->user->balance, 2) }}</span>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Withdrawal Details</h3>
          <div class="space-y-3">
            <div class="flex justify-between items-center">
              <span class="text-gray-600">Amount:</span>
              <div class="flex items-center space-x-2">
                <span class="font-medium text-blue-600">${{ number_format($withdrawal->amount, 2) }}</span>
                <button onclick="copyToClipboard('${{ number_format($withdrawal->amount, 2) }}', this)"
                        class="text-blue-600 hover:text-blue-800 transition-colors"
                        title="Copy amount">
                  <i class="fa-solid fa-copy text-sm"></i>
                </button>
              </div>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Payment Method:</span>
              <span class="font-medium">{{ ucfirst($withdrawal->method ?? 'Bank Transfer') }}</span>
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

      <!-- Bank Details -->
      @if($withdrawal->account_details)
        <div class="bg-gray-50 p-6 rounded-xl mb-8">
          <h3 class="text-lg font-semibold mb-4">Bank Details</h3>
          <div class="bg-white p-4 rounded-lg">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
              @if(isset($withdrawal->account_details['bank_name']))
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">Bank Name:</span>
                  <div class="flex items-center space-x-2">
                    <span class="font-medium">{{ $withdrawal->account_details['bank_name'] }}</span>
                    <button onclick="copyToClipboard('{{ $withdrawal->account_details['bank_name'] }}', this)"
                            class="text-blue-600 hover:text-blue-800 transition-colors"
                            title="Copy bank name">
                      <i class="fa-solid fa-copy text-sm"></i>
                    </button>
                  </div>
                </div>
              @endif
              @if(isset($withdrawal->account_details['account_name']))
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">Account Name:</span>
                  <div class="flex items-center space-x-2">
                    <span class="font-medium">{{ $withdrawal->account_details['account_name'] }}</span>
                    <button onclick="copyToClipboard('{{ $withdrawal->account_details['account_name'] }}', this)"
                            class="text-blue-600 hover:text-blue-800 transition-colors"
                            title="Copy account name">
                      <i class="fa-solid fa-copy text-sm"></i>
                    </button>
                  </div>
                </div>
              @endif
              @if(isset($withdrawal->account_details['account_number']))
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">Account Number:</span>
                  <div class="flex items-center space-x-2">
                    <span class="font-medium font-mono">{{ $withdrawal->account_details['account_number'] }}</span>
                    <button onclick="copyToClipboard('{{ $withdrawal->account_details['account_number'] }}', this)"
                            class="text-blue-600 hover:text-blue-800 transition-colors"
                            title="Copy account number">
                      <i class="fa-solid fa-copy text-sm"></i>
                    </button>
                  </div>
                </div>
              @endif
              @if(isset($withdrawal->account_details['routing_number']))
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">Routing Number:</span>
                  <div class="flex items-center space-x-2">
                    <span class="font-medium font-mono">{{ $withdrawal->account_details['routing_number'] }}</span>
                    <button onclick="copyToClipboard('{{ $withdrawal->account_details['routing_number'] }}', this)"
                            class="text-blue-600 hover:text-blue-800 transition-colors"
                            title="Copy routing number">
                      <i class="fa-solid fa-copy text-sm"></i>
                    </button>
                  </div>
                </div>
              @endif
              @if(isset($withdrawal->account_details['swift_code']))
                <div class="flex justify-between items-center">
                  <span class="text-gray-600">SWIFT Code:</span>
                  <div class="flex items-center space-x-2">
                    <span class="font-medium font-mono">{{ $withdrawal->account_details['swift_code'] }}</span>
                    <button onclick="copyToClipboard('{{ $withdrawal->account_details['swift_code'] }}', this)"
                            class="text-blue-600 hover:text-blue-800 transition-colors"
                            title="Copy SWIFT code">
                      <i class="fa-solid fa-copy text-sm"></i>
                    </button>
                  </div>
                </div>
              @endif
            </div>
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

<script>
function copyToClipboard(text, button) {
    // Create a temporary textarea element
    const textarea = document.createElement('textarea');
    textarea.value = text;
    document.body.appendChild(textarea);

    // Select and copy the text
    textarea.select();
    document.execCommand('copy');

    // Remove the temporary element
    document.body.removeChild(textarea);

    // Change button icon to show success
    const icon = button.querySelector('i');
    const originalClass = icon.className;
    icon.className = 'fa-solid fa-check text-sm text-green-600';

    // Show success message
    const originalTitle = button.title;
    button.title = 'Copied!';

    // Reset after 2 seconds
    setTimeout(() => {
        icon.className = originalClass;
        button.title = originalTitle;
    }, 2000);
}
</script>

@endsection
