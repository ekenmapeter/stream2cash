<!-- Task Watchers View -->
@extends('admin.layouts.app')

@section('title', 'Task Watchers: ' . $task->title)

@section('content')
<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-7xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Task Watchers</h1>
          <p class="text-gray-600">{{ $task->title }}</p>
        </div>
        <a href="{{ route('admin.tasks.show', $task) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Task
        </a>
      </div>

      <!-- Statistics Overview -->
      <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-8">
        <div class="bg-blue-50 p-4 rounded-lg text-center">
          <div class="text-2xl font-bold text-blue-600">{{ $task_stats['total_watches'] }}</div>
          <div class="text-sm text-gray-600">Total Watches</div>
        </div>
        <div class="bg-green-50 p-4 rounded-lg text-center">
          <div class="text-2xl font-bold text-green-600">{{ $task_stats['valid_watches'] }}</div>
          <div class="text-sm text-gray-600">Valid Watches</div>
        </div>
        <div class="bg-red-50 p-4 rounded-lg text-center">
          <div class="text-2xl font-bold text-red-600">{{ $task_stats['invalid_watches'] }}</div>
          <div class="text-sm text-gray-600">Invalid Watches</div>
        </div>
        <div class="bg-yellow-50 p-4 rounded-lg text-center">
          <div class="text-2xl font-bold text-yellow-600">₦{{ number_format($task_stats['total_rewards'], 2) }}</div>
          <div class="text-sm text-gray-600">Total Rewards</div>
        </div>
        <div class="bg-purple-50 p-4 rounded-lg text-center">
          <div class="text-2xl font-bold text-purple-600">{{ number_format($task_stats['avg_watch_percentage'], 1) }}%</div>
          <div class="text-sm text-gray-600">Avg Watch %</div>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="bg-gray-50 p-6 rounded-xl mb-6">
        <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Name or email..."
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Validation Status</label>
            <select name="is_valid" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
              <option value="">All Status</option>
              <option value="1" {{ request('is_valid') === '1' ? 'selected' : '' }}>Valid</option>
              <option value="0" {{ request('is_valid') === '0' ? 'selected' : '' }}>Invalid</option>
            </select>
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Min Watch %</label>
            <input type="number" name="min_percentage" value="{{ request('min_percentage') }}" placeholder="0" min="0" max="100"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Max Watch %</label>
            <input type="number" name="max_percentage" value="{{ request('max_percentage') }}" placeholder="100" min="0" max="100"
                   class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>

          <div class="md:col-span-2 lg:col-span-4 flex gap-2">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
              <i class="fa-solid fa-search mr-2"></i>Search
            </button>
            <a href="{{ route('admin.tasks.watchers', $task) }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
              <i class="fa-solid fa-times mr-2"></i>Clear
            </a>
          </div>
        </form>
      </div>

      <!-- Sort Options -->
      <div class="flex justify-between items-center mb-4">
        <div class="flex items-center space-x-4">
          <span class="text-sm text-gray-600">Sort by:</span>
          <select onchange="updateSort('sort_by', this.value)" class="px-3 py-1 border border-gray-300 rounded text-sm">
            <option value="watched_at" {{ request('sort_by') === 'watched_at' ? 'selected' : '' }}>Date Watched</option>
            <option value="watch_percentage" {{ request('sort_by') === 'watch_percentage' ? 'selected' : '' }}>Watch Percentage</option>
            <option value="reward_earned" {{ request('sort_by') === 'reward_earned' ? 'selected' : '' }}>Reward Earned</option>
            <option value="watch_duration" {{ request('sort_by') === 'watch_duration' ? 'selected' : '' }}>Watch Duration</option>
          </select>
          <select onchange="updateSort('sort_order', this.value)" class="px-3 py-1 border border-gray-300 rounded text-sm">
            <option value="desc" {{ request('sort_order') === 'desc' ? 'selected' : '' }}>Descending</option>
            <option value="asc" {{ request('sort_order') === 'asc' ? 'selected' : '' }}>Ascending</option>
          </select>
        </div>
        <div class="text-sm text-gray-600">
          Showing {{ $watchers->firstItem() ?? 0 }} to {{ $watchers->lastItem() ?? 0 }} of {{ $watchers->total() }} results
        </div>
      </div>

      <!-- Watchers Table -->
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Watch Stats</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Validation</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reward</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($watchers as $watch)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center">
                        <i class="fa-solid fa-user text-gray-600"></i>
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ $watch->user->name }}</div>
                      <div class="text-sm text-gray-500">{{ $watch->user->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm text-gray-900">
                    <div class="flex items-center">
                      <i class="fa-solid fa-clock mr-1 text-gray-400"></i>
                      {{ gmdate('H:i:s', $watch->watch_duration) }}
                    </div>
                    <div class="flex items-center mt-1">
                      <i class="fa-solid fa-percentage mr-1 text-gray-400"></i>
                      {{ number_format($watch->watch_percentage, 1) }}%
                    </div>
                    <div class="flex items-center mt-1">
                      <i class="fa-solid fa-play mr-1 text-gray-400"></i>
                      {{ $watch->seek_count }} seeks, {{ $watch->pause_count }} pauses
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="flex flex-col space-y-1">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $watch->is_valid ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                      {{ $watch->is_valid ? 'Valid' : 'Invalid' }}
                    </span>
                    @if($watch->tab_visible)
                      <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Tab Visible</span>
                    @else
                      <span class="px-2 py-1 text-xs bg-yellow-100 text-yellow-800 rounded-full">Tab Hidden</span>
                    @endif
                    @if($watch->validation_notes)
                      <div class="text-xs text-gray-500 mt-1">
                        <i class="fa-solid fa-exclamation-triangle mr-1"></i>
                        {{ Str::limit(implode(', ', $watch->validation_notes), 30) }}
                      </div>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-4">
                  <div class="text-sm">
                    <div class="font-medium text-green-600">₦{{ number_format($watch->reward_earned, 2) }}</div>
                    @if($watch->earning)
                      <div class="text-xs text-gray-500">Paid</div>
                    @else
                      <div class="text-xs text-red-500">Not Paid</div>
                    @endif
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  <div>{{ $watch->watched_at->format('M d, Y') }}</div>
                  <div class="text-xs">{{ $watch->watched_at->format('H:i:s') }}</div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <button onclick="showWatchDetails({{ $watch->id }})" class="text-blue-600 hover:text-blue-900">
                      <i class="fa-solid fa-eye"></i>
                    </button>
                    @if(!$watch->earning && $watch->is_valid)
                      <button onclick="creditReward({{ $watch->id }})" class="text-green-600 hover:text-green-900">
                        <i class="fa-solid fa-money-bill-wave"></i>
                      </button>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No watchers found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($watchers->hasPages())
        <div class="mt-6">
          {{ $watchers->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </section>
</div>

<!-- Watch Details Modal -->
<div id="watchDetailsModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
  <div class="flex items-center justify-center min-h-screen p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-96 overflow-y-auto">
      <div class="px-6 py-4 border-b border-gray-200">
        <h3 class="text-lg font-semibold text-gray-900">Watch Details</h3>
        <button onclick="closeWatchDetails()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600">
          <i class="fa-solid fa-times"></i>
        </button>
      </div>
      <div id="watchDetailsContent" class="px-6 py-4">
        <!-- Content will be loaded here -->
      </div>
    </div>
  </div>
</div>

<script>
function updateSort(param, value) {
  const url = new URL(window.location);
  url.searchParams.set(param, value);
  window.location = url;
}

function showWatchDetails(watchId) {
  // This would typically make an AJAX call to get detailed watch data
  document.getElementById('watchDetailsContent').innerHTML = `
    <div class="text-center py-8">
      <i class="fa-solid fa-spinner fa-spin text-2xl text-gray-400 mb-4"></i>
      <p class="text-gray-600">Loading watch details...</p>
    </div>
  `;
  document.getElementById('watchDetailsModal').classList.remove('hidden');
}

function closeWatchDetails() {
  document.getElementById('watchDetailsModal').classList.add('hidden');
}

function creditReward(watchId) {
  if (confirm('Are you sure you want to credit the reward for this watch?')) {
    // This would typically make an AJAX call to credit the reward
    alert('Reward credited successfully!');
    location.reload();
  }
}
</script>
@endsection
