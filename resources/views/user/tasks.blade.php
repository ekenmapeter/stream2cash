@extends('user.layouts.app')

@section('title', 'Tasks | Stream2Cash')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow">
    <!-- Tasks Header -->
    <header class="p-6 pt-0">
        <h1 class="text-2xl font-bold mb-1">Available Tasks</h1>
        <p class="text-sm text-gray-400">Complete tasks to earn money</p>
    </header>

    <!-- Tasks Grid -->
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @forelse($tasks as $task)
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <img src="{{ $task->thumbnail_url ?? $task->thumbnail ?? 'https://placehold.co/600x300/0000FF/FFFFFF?text=Video' }}" alt="{{ $task->title }}" class="w-full h-48 object-cover">
            <div class="p-6">
                <h3 class="text-xl font-semibold mb-2">{{ $task->title }}</h3>
                <p class="text-gray-400 text-sm mb-4">{{ Str::limit($task->description, 140) }}</p>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-bold text-yellow-500">₦{{ number_format($task->reward_per_view, 2) }}</span>
                    @php $isCompleted = isset($completed_task_ids) && in_array($task->id, $completed_task_ids); @endphp
                    <span class="px-3 py-1 text-xs rounded-full {{ $isCompleted ? 'bg-green-700 text-green-100' : 'bg-red-700 text-red-100' }}">
                        {{ $isCompleted ? 'Completed' : 'Available' }}
                    </span>
                </div>
                <button class="w-full {{ $isCompleted ? 'bg-gray-600 cursor-not-allowed' : 'bg-blue-700 hover:bg-blue-600' }} text-white py-2 px-4 rounded-lg transition-colors" {{ $isCompleted ? 'disabled' : '' }}>
                    {{ $isCompleted ? 'Completed' : 'Start Task' }}
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-12">
            <i class="fa-solid fa-list-check text-6xl text-gray-600 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-400 mb-2">No Tasks Available</h3>
            <p class="text-gray-500">Check back later for new earning opportunities!</p>
        </div>
        @endforelse
    </section>

    @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
    <div class="mt-6">
        {{ $tasks->links() }}
    </div>
    @endif
</main>
@endsection
