<!-- Task Details View -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Task Details</h1>
          <p class="text-gray-600">View and manage {{ $task->title }}</p>
        </div>
        <a href="{{ route('admin.tasks') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Tasks
        </a>
      </div>

      <!-- Task Info -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Task Information</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Title:</span>
              <span class="font-medium">{{ $task->title }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Status:</span>
              <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $task->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                {{ ucfirst($task->status) }}
              </span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Reward per View:</span>
              <span class="font-medium text-green-600">₪{{ number_format($task->reward_per_view, 2) }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Created:</span>
              <span class="font-medium">{{ $task->created_at->format('M d, Y') }}</span>
            </div>
          </div>
        </div>

        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Statistics</h3>
          <div class="space-y-3">
            <div class="flex justify-between">
              <span class="text-gray-600">Total Views:</span>
              <span class="font-medium">{{ $task_stats['total_watches'] }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Unique Users:</span>
              <span class="font-medium">{{ $task_stats['unique_users'] }}</span>
            </div>
            <div class="flex justify-between">
              <span class="text-gray-600">Total Rewards Paid:</span>
              <span class="font-medium">₪{{ number_format($task_stats['total_rewards'], 2) }}</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Description -->
      <div class="bg-gray-50 p-6 rounded-xl mb-8">
        <h3 class="text-lg font-semibold mb-4">Description</h3>
        <p class="text-gray-700">{{ $task->description }}</p>
      </div>

      <!-- Video URL -->
      <div class="bg-gray-50 p-6 rounded-xl mb-8">
        <h3 class="text-lg font-semibold mb-4">Video URL</h3>
        <a href="{{ $task->url }}" target="_blank" class="text-blue-600 hover:text-blue-800 break-all">
          {{ $task->url }}
        </a>
      </div>

      <!-- Actions -->
      <div class="flex gap-4">
        <form method="POST" action="{{ route('admin.tasks.toggle-status', $task) }}">
          @csrf
          @method('PATCH')
          <button type="submit" class="bg-yellow-600 hover:bg-yellow-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-toggle-{{ $task->status === 'active' ? 'on' : 'off' }} mr-2"></i>
            {{ $task->status === 'active' ? 'Deactivate' : 'Activate' }} Task
          </button>
        </form>

        <form method="POST" action="{{ route('admin.tasks.delete', $task) }}"
              onsubmit="return confirm('Are you sure you want to delete this task? This action cannot be undone.')">
          @csrf
          @method('DELETE')
          <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-trash mr-2"></i>Delete Task
          </button>
        </form>
      </div>

    </div>
  </section>
</div>

@endsection
