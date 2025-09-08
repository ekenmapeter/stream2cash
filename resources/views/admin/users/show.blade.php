<!-- User Details View -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-8">
  <section class="flex justify-center items-center py-8 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">User Details</h1>
          <p class="text-gray-600">View and manage {{ $user->name }}'s account</p>
        </div>
        <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Users
        </a>
      </div>

      <!-- User Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Basic Information</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Name:</span>
              <span class="font-medium">{{ $user->name }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Email:</span>
              <span class="font-medium">{{ $user->email }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Role:</span>
              <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                {{ ucfirst($user->role) }}
              </span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Status:</span>
              <span class="px-2 py-1 text-xs font-semibold rounded-full
                {{ $user->status === 'active' ? 'bg-green-100 text-green-800' :
                   ($user->status === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                {{ ucfirst($user->status ?? 'active') }}
              </span>
            </div>
            @if($user->status === 'suspended' && $user->suspension_reason)
              <div class="flex justify-between">
                <span class="text-gray-600">Suspension Reason:</span>
                <span class="text-sm text-red-600">{{ $user->suspension_reason }}</span>
              </div>
            @endif
            @if($user->status === 'blocked' && $user->block_reason)
              <div class="flex justify-between">
                <span class="text-gray-600">Block Reason:</span>
                <span class="text-sm text-red-600">{{ $user->block_reason }}</span>
              </div>
            @endif
            <div class="flex justify-between">
              <span class="text-gray-600">Joined:</span>
              <span class="font-medium">{{ $user->created_at->format('M d, Y') }}</span>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Statistics</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Current Balance:</span>
              <span class="font-medium text-green-600">₦ {{ number_format($user->balance, 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Total Earnings:</span>
              <span class="font-medium">₦ {{ number_format($user_stats['total_earnings'], 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Total Withdrawals:</span>
              <span class="font-medium">₦ {{ number_format($user_stats['total_withdrawals'], 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Pending Withdrawals:</span>
              <span class="font-medium text-yellow-600">₦ {{ number_format($user_stats['pending_withdrawals'], 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Tasks Completed:</span>
              <span class="font-medium">{{ $user_stats['tasks_completed'] }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Balance Management -->
      <div class="bg-blue-50 p-6 rounded-xl mb-8">
        <h3 class="text-lg font-semibold mb-4">Balance Management</h3>
        <form method="POST" action="{{ route('admin.users.update-balance', $user) }}" class="flex gap-4">
          @csrf
          @method('PATCH')
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">New Balance</label>
            <input type="number" name="balance" value="{{ $user->balance }}" step="0.01" min="0"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
          </div>
          <div class="flex-1">
            <label class="block text-sm font-medium text-gray-700 mb-2">Reason</label>
            <input type="text" name="reason" placeholder="Reason for balance change..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
          </div>
          <div class="flex items-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
              Update Balance
            </button>
          </div>
        </form>
      </div>

      <!-- Recent Withdrawals -->
      <div class="bg-gray-50 p-6 rounded-xl mb-8">
        <h3 class="text-lg font-semibold mb-4">Recent Withdrawals</h3>
        @if($user_withdrawals->count() > 0)
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b">
                  <th class="text-left py-2">Amount</th>
                  <th class="text-left py-2">Status</th>
                  <th class="text-left py-2">Requested</th>
                  <th class="text-left py-2">Processed</th>
                </tr>
              </thead>
              <tbody>
                @foreach($user_withdrawals as $withdrawal)
                  <tr class="border-b">
                    <td class="py-2 font-medium">₦ {{ number_format($withdrawal->amount, 2) }}</td>
                    <td class="py-2">
                      <span class="px-2 py-1 text-xs font-semibold rounded-full
                        {{ $withdrawal->status === 'completed' ? 'bg-green-100 text-green-800' :
                           ($withdrawal->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ ucfirst($withdrawal->status) }}
                      </span>
                    </td>
                    <td class="py-2 text-gray-600">{{ $withdrawal->requested_at->format('M d, Y') }}</td>
                    <td class="py-2 text-gray-600">
                      {{ $withdrawal->processed_at ? $withdrawal->processed_at->format('M d, Y') : 'N/A' }}
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-4">
            {{ $user_withdrawals->links() }}
          </div>
        @else
          <p class="text-gray-500">No withdrawals found.</p>
        @endif
      </div>

      <!-- Recent Earnings/Tasks -->
      <div class="bg-gray-50 p-6 rounded-xl mb-8">
        <h3 class="text-lg font-semibold mb-4">Recent Earnings</h3>
        @if($user_earnings->count() > 0)
          <div class="overflow-x-auto">
            <table class="w-full text-sm">
              <thead>
                <tr class="border-b">
                  <th class="text-left py-2">Amount</th>
                  <th class="text-left py-2">Source</th>
                  <th class="text-left py-2">Date</th>
                  <th class="text-left py-2">Status</th>
                </tr>
              </thead>
              <tbody>
                @foreach($user_earnings as $earning)
                  <tr class="border-b">
                    <td class="py-2 font-medium text-green-600">₦ {{ number_format($earning->amount, 2) }}</td>
                    <td class="py-2">{{ $earning->source ?? 'Task Completion' }}</td>
                    <td class="py-2 text-gray-600">{{ $earning->created_at->format('M d, Y') }}</td>
                    <td class="py-2">
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                        Completed
                      </span>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
          <div class="mt-4">
            {{ $user_earnings->links() }}
          </div>
        @else
          <p class="text-gray-500">No earnings found.</p>
        @endif
      </div>

      <!-- IP Records Section -->
      <div class="bg-gray-50 p-6 rounded-xl mb-8">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold">IP Records</h3>
          <a href="{{ route('admin.users.ip-records', $user) }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
            View All IP Records <i class="fa-solid fa-arrow-right ml-1"></i>
          </a>
        </div>
        @php
          $recentIps = $user->ipRecords()->orderBy('created_at', 'desc')->limit(3)->get();
        @endphp
        @if($recentIps->count() > 0)
          <div class="space-y-3">
            @foreach($recentIps as $ipRecord)
              <div class="flex justify-between items-center p-3 bg-white rounded-lg border {{ $ipRecord->is_suspicious ? 'border-red-200 bg-red-50' : 'border-gray-200' }}">
                <div class="flex-1">
                  <div class="flex items-center gap-2">
                    <span class="font-mono text-sm">{{ $ipRecord->ip_address }}</span>
                    @if($ipRecord->is_suspicious)
                      <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                        <i class="fa-solid fa-exclamation-triangle mr-1"></i>Suspicious
                      </span>
                    @endif
                  </div>
                  <div class="text-xs text-gray-500 mt-1">
                    {{ $ipRecord->location }} • {{ $ipRecord->device_info }} • {{ $ipRecord->created_at->diffForHumans() }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        @else
          <p class="text-gray-500">No IP records found.</p>
        @endif
      </div>

      <!-- Actions -->
      <div class="space-y-4">
        <!-- Status Management -->
        <div class="flex flex-wrap gap-3">
          @if($user->status === 'active')
            <!-- Suspend User -->
            <button onclick="openSuspendModal()" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
              <i class="fa-solid fa-pause mr-2"></i>Suspend User
            </button>
            <!-- Block User -->
            <button onclick="openBlockModal()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
              <i class="fa-solid fa-ban mr-2"></i>Block User
            </button>
          @elseif($user->status === 'suspended')
            <!-- Activate User -->
            <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fa-solid fa-check mr-2"></i>Activate User
              </button>
            </form>
            <!-- Block User -->
            <button onclick="openBlockModal()" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
              <i class="fa-solid fa-ban mr-2"></i>Block User
            </button>
          @elseif($user->status === 'blocked')
            <!-- Activate User -->
            <form method="POST" action="{{ route('admin.users.activate', $user) }}" class="inline">
              @csrf
              @method('PATCH')
              <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fa-solid fa-check mr-2"></i>Activate User
              </button>
            </form>
          @endif
        </div>

        <!-- Other Actions -->
        <div class="flex flex-wrap gap-3">
          @if($user->role === 'user' && $user->status === 'active')
            <form method="POST" action="{{ route('admin.impersonate', $user) }}" class="inline">
              @csrf
              <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition-colors"
                      onclick="return confirm('Are you sure you want to impersonate this user?')">
                <i class="fa-solid fa-user-secret mr-2"></i>Impersonate User
              </button>
            </form>
          @endif
          @if($user->id !== Auth::id())
            <form method="POST" action="{{ route('admin.users.delete', $user) }}"
                  onsubmit="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
              @csrf
              @method('DELETE')
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                <i class="fa-solid fa-trash mr-2"></i>Delete User
              </button>
            </form>
          @endif
        </div>
      </div>

      <!-- Suspend User Modal -->
      <div id="suspendModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
          <h3 class="text-lg font-semibold mb-4">Suspend User</h3>
          <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
            @csrf
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Reason for suspension</label>
              <textarea name="reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-transparent" placeholder="Enter reason for suspending this user..." required></textarea>
            </div>
            <div class="flex gap-3">
              <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-4 py-2 rounded-lg transition-colors">
                Suspend User
              </button>
              <button type="button" onclick="closeSuspendModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>

      <!-- Block User Modal -->
      <div id="blockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md mx-4">
          <h3 class="text-lg font-semibold mb-4">Block User</h3>
          <form method="POST" action="{{ route('admin.users.block', $user) }}">
            @csrf
            <div class="mb-4">
              <label class="block text-sm font-medium text-gray-700 mb-2">Reason for blocking</label>
              <textarea name="reason" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent" placeholder="Enter reason for blocking this user..." required></textarea>
            </div>
            <div class="flex gap-3">
              <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                Block User
              </button>
              <button type="button" onclick="closeBlockModal()" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-lg transition-colors">
                Cancel
              </button>
            </div>
          </form>
        </div>
      </div>

      <script>
        function openSuspendModal() {
          document.getElementById('suspendModal').classList.remove('hidden');
          document.getElementById('suspendModal').classList.add('flex');
        }

        function closeSuspendModal() {
          document.getElementById('suspendModal').classList.add('hidden');
          document.getElementById('suspendModal').classList.remove('flex');
        }

        function openBlockModal() {
          document.getElementById('blockModal').classList.remove('hidden');
          document.getElementById('blockModal').classList.add('flex');
        }

        function closeBlockModal() {
          document.getElementById('blockModal').classList.add('hidden');
          document.getElementById('blockModal').classList.remove('flex');
        }

        // Close modals when clicking outside
        document.getElementById('suspendModal').addEventListener('click', function(e) {
          if (e.target === this) closeSuspendModal();
        });

        document.getElementById('blockModal').addEventListener('click', function(e) {
          if (e.target === this) closeBlockModal();
        });
      </script>

    </div>
  </section>
</div>

@endsection
