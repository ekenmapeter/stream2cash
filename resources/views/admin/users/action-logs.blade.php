<!-- User Action Logs -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-7xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">User Action Logs</h1>
          <p class="text-gray-600">Track all admin actions performed on user accounts</p>
        </div>
        <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Users
        </a>
      </div>

      <!-- Filters -->
      <div class="bg-gray-50 p-4 rounded-xl mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Action</label>
            <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="">All Actions</option>
              @foreach($actions as $action)
                <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                  {{ ucfirst(str_replace('_', ' ', $action)) }}
                </option>
              @endforeach
            </select>
          </div>
          
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Admin</label>
            <select name="admin_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="">All Admins</option>
              @foreach($admins as $admin)
                <option value="{{ $admin->id }}" {{ request('admin_id') == $admin->id ? 'selected' : '' }}>
                  {{ $admin->name }}
                </option>
              @endforeach
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
            <input type="date" name="date_from" value="{{ request('date_from') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
            <input type="date" name="date_to" value="{{ request('date_to') }}" 
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
          </div>

          <div class="flex items-end">
            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
              <i class="fa-solid fa-filter mr-2"></i>Filter
            </button>
          </div>
        </form>
      </div>

      <!-- Action Logs Table -->
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Admin</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Target User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">IP Address</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($logs as $log)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8">
                      <div class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold text-sm">
                        {{ strtoupper(substr($log->admin->name, 0, 1)) }}
                      </div>
                    </div>
                    <div class="ml-3">
                      <div class="text-sm font-medium text-gray-900">{{ $log->admin->name }}</div>
                      <div class="text-sm text-gray-500">{{ $log->admin->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-8 w-8">
                      <div class="h-8 w-8 rounded-full bg-green-500 flex items-center justify-center text-white font-semibold text-sm">
                        {{ strtoupper(substr($log->targetUser->name, 0, 1)) }}
                      </div>
                    </div>
                    <div class="ml-3">
                      <div class="text-sm font-medium text-gray-900">{{ $log->targetUser->name }}</div>
                      <div class="text-sm text-gray-500">{{ $log->targetUser->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  @php
                    $actionColors = [
                      'suspend' => 'bg-yellow-100 text-yellow-800',
                      'block' => 'bg-red-100 text-red-800',
                      'activate' => 'bg-green-100 text-green-800',
                      'update_balance' => 'bg-blue-100 text-blue-800',
                      'delete' => 'bg-red-100 text-red-800',
                      'impersonate' => 'bg-purple-100 text-purple-800'
                    ];
                  @endphp
                  <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $actionColors[$log->action] ?? 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst(str_replace('_', ' ', $log->action)) }}
                  </span>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900 max-w-xs truncate" title="{{ $log->description }}">
                    {{ $log->description }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $log->ip_address ?? 'N/A' }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $log->created_at->format('M d, Y H:i') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <button onclick="showLogDetails({{ $log->id }})" 
                          class="text-blue-600 hover:text-blue-900">
                    <i class="fa-solid fa-eye"></i>
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No action logs found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($logs->hasPages())
        <div class="mt-6">
          {{ $logs->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </section>
</div>

<!-- Log Details Modal -->
<div id="logDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg max-w-2xl w-full max-h-96 overflow-y-auto">
      <div class="p-6">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-lg font-semibold text-gray-900">Action Details</h3>
          <button onclick="closeLogDetails()" class="text-gray-400 hover:text-gray-600">
            <i class="fa-solid fa-times"></i>
          </button>
        </div>
        <div id="logDetailsContent">
          <!-- Content will be loaded here -->
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function showLogDetails(logId) {
  // This would typically make an AJAX request to get log details
  // For now, we'll show a placeholder
  document.getElementById('logDetailsContent').innerHTML = `
    <div class="space-y-4">
      <div>
        <label class="block text-sm font-medium text-gray-700">Action ID:</label>
        <p class="text-sm text-gray-900">${logId}</p>
      </div>
      <div>
        <label class="block text-sm font-medium text-gray-700">Note:</label>
        <p class="text-sm text-gray-900">Detailed log information would be loaded here via AJAX.</p>
      </div>
    </div>
  `;
  document.getElementById('logDetailsModal').classList.remove('hidden');
}

function closeLogDetails() {
  document.getElementById('logDetailsModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('logDetailsModal').addEventListener('click', function(e) {
  if (e.target === this) {
    closeLogDetails();
  }
});
</script>

@endsection
