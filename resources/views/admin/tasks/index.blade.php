<!-- Task Management Index -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Task Management</h1>
          <p class="text-gray-600">Create and manage earning tasks</p>
        </div>
        <div class="flex gap-4">
          <a href="{{ route('admin.tasks.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-plus mr-2"></i>Create Task
          </a>
          <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
          </a>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="bg-gray-50 p-4 rounded-xl mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tasks by title or description..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>
          <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-search mr-2"></i>Search
          </button>
        </form>
      </div>

      <!-- Tasks Table -->
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reward per View</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Views</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($tasks as $task)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">
                  <div>
                    <div class="text-sm font-medium text-gray-900">{{Str::limit($task->title, 35) }}</div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ₦{{ number_format($task->reward_per_view, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                  <div class="flex items-center">
                    <i class="fa-solid fa-eye mr-1 text-gray-400"></i>
                    {{ $task->watches()->count() }}
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $task->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($task->status) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $task->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <a href="{{ route('admin.tasks.show', $task) }}" class="text-blue-600 hover:text-blue-900" title="View Task">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.tasks.watchers', $task) }}" class="text-green-600 hover:text-green-900" title="View Watchers">
                      <i class="fa-solid fa-users"></i>
                    </a>
                    <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}" class="inline">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Toggle Status">
                        <i class="fa-solid fa-toggle-{{ $task->status === 'active' ? 'on' : 'off' }}"></i>
                      </button>
                    </form>
                    <form method="POST" action="{{ route('admin.tasks.delete', $task) }}" class="inline"
                          onsubmit="return confirm('Are you sure you want to delete this task?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-600 hover:text-red-900" title="Delete Task">
                        <i class="fa-solid fa-trash"></i>
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No tasks found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($tasks->hasPages())
        <div class="mt-6">
          {{ $tasks->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </section>
</div>

@endsection
