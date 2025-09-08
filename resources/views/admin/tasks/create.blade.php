<!-- Create Task Form -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-16 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New Task</h1>
          <p class="text-gray-600">Add a new earning task for users</p>
        </div>
        <a href="{{ route('admin.tasks') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Tasks
        </a>
      </div>

      <!-- Create Task Form -->
      <form method="POST" action="{{ route('admin.tasks.store') }}" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
          <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Task Title *</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                   placeholder="Enter task title" required>
            @error('title')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="reward_per_view" class="block text-sm font-medium text-gray-700 mb-2">Reward per View (₪) *</label>
            <input type="number" id="reward_per_view" name="reward_per_view" value="{{ old('reward_per_view') }}"
                   step="0.01" min="0.01"
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('reward_per_view') border-red-500 @enderror"
                   placeholder="0.00" required>
            @error('reward_per_view')
              <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
          </div>
        </div>

        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description *</label>
          <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('description') border-red-500 @enderror"
                    placeholder="Describe what users need to do for this task" required>{{ old('description') }}</textarea>
          @error('description')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="url" class="block text-sm font-medium text-gray-700 mb-2">Video URL *</label>
          <input type="url" id="url" name="url" value="{{ old('url') }}"
                 class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('url') border-red-500 @enderror"
                 placeholder="https://example.com/video" required>
          @error('url')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div>
          <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
          <select id="status" name="status"
                  class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror" required>
            <option value="">Select status</option>
            <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          @error('status')
            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
          @enderror
        </div>

        <div class="flex gap-4">
          <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-save mr-2"></i>Create Task
          </button>
          <a href="{{ route('admin.tasks') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-6 py-2 rounded-lg transition-colors">
            Cancel
          </a>
        </div>
      </form>

    </div>
  </section>
</div>

@endsection
