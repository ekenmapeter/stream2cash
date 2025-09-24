@extends('user.layouts.app')

@section('title', $task->title . ' | StreamAdolla')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow pt-20">
    <!-- Back Button -->
    <div class="p-6 pt-0">
        <a href="{{ route('user.tasks') }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Back to Tasks
        </a>
    </div>

    <div class="px-6 pb-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Task Details -->
            <div class="lg:col-span-2">
                <div class="bg-blue-800 rounded-xl shadow-lg overflow-hidden">
                    <!-- Task Thumbnail/Video Preview -->
                    <div class="relative">
                        <img src="{{ $thumbnailUrl }}" alt="{{ $task->title }}" class="w-full h-64 object-cover">
                        @if($isCompleted)
                            <div class="absolute inset-0 bg-green-900 bg-opacity-80 flex items-center justify-center">
                                <div class="text-center text-white">
                                    <i class="fa-solid fa-check-circle text-6xl mb-4"></i>
                                    <h3 class="text-2xl font-bold">Task Completed!</h3>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Task Information -->
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <div>
                                <h1 class="text-1xl text-white font-bold mb-2">{{ $task->title }}</h1>
                                <div class="flex items-center space-x-4 text-xs text-gray-200">
                                    <span><i class="fa-solid fa-calendar mr-1"></i>{{ $task->created_at->format('M d, Y') }}</span>
                                    <span class="px-2 py-1 rounded-full {{ $task->status === 'active' ? 'bg-green-700 text-green-100' : 'bg-red-700 text-red-100' }}">
                                        {{ ucfirst($task->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="text-right">
                                @if($isCompleted)
                                <div class="text-2xl font-bold text-green-500 px-2 py-1 bg-white rounded-lg">₦{{ number_format($task->reward_per_view, 2) }}</div>

                            @else
                            <div class="text-3xl font-bold text-yellow-500">₦{{ number_format($task->reward_per_view, 2) }}</div>

                            @endif
                                <div class="text-sm text-gray-200">Reward per view</div>
                            </div>
                        </div>

                        <!-- Task Description -->
                        <div class="mb-6">
                            <h3 class="text-sm font-semibold mb-2 text-white">Description</h3>
                            <p class="text-gray-200 text-xs leading-relaxed">{{ $task->description }}</p>
                        </div>

                        <!-- Action Button -->
                        @if($isCompleted)
                            <button class="w-full bg-green-600 cursor-not-allowed text-white py-3 px-6 rounded-lg transition-colors" disabled>
                                <i class="fa-solid fa-check mr-2"></i>Task Completed
                            </button>
                        @else
                            <a href="{{ route('user.tasks.watch', $task) }}" class="w-full bg-blue-700 hover:bg-blue-600 text-white py-3 px-6 rounded-lg transition-colors inline-block text-center">
                                <i class="fa-solid fa-play mr-2"></i>Watch Task
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Task Statistics -->
                <div class="bg-blue-800 rounded-xl shadow-lg p-6">
                    <h3 class="text-lg font-semibold text-white mb-4">Task Statistics</h3>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-200">Total Views</span>
                            <span class="font-semibold text-gray-200">{{ $task->watches()->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-200">Unique Users</span>
                            <span class="font-semibold text-gray-200">{{ $task->watches()->distinct('user_id')->count() }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-200">Total Rewards Paid</span>
                            <span class=" bg-white px-2 py-1 rounded-lg font-semibold text-green-800">₦{{ number_format($task->watches()->sum('reward_earned'), 2) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Related Tasks -->
                @if($relatedTasks->count() > 0)
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Related Tasks</h3>
                    <div class="space-y-4">
                        @foreach($relatedTasks as $relatedTask)
                            @php $relatedCompleted = in_array($relatedTask->id, $completed_task_ids); @endphp
                            <div class="flex items-center space-x-3 p-3 rounded-lg {{ $relatedCompleted ? 'bg-blue-700' : 'bg-blue-700 hover:bg-blue-600' }} transition-colors">
                                <img src="{{ $relatedTask->thumbnail_url ?? $relatedTask->thumbnail ?? 'https://placehold.co/80x60/0000FF/FFFFFF?text=Video' }}"
                                     alt="{{ $relatedTask->title }}"
                                     class="w-16 h-12 object-cover rounded">
                                <div class="flex-1 min-w-0">
                                    <h4 class="text-sm font-medium text-white truncate">{{ $relatedTask->title }}</h4>
                                    <p class="text-xs text-gray-400">₦{{ number_format($relatedTask->reward_per_view, 2) }}</p>
                                </div>
                                @if($relatedCompleted)
                                    <i class="fa-solid fa-check-circle text-green-400"></i>
                                @else
                                    <a href="{{ route('user.tasks.details', $relatedTask) }}" class="text-blue-400 hover:text-blue-300">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection
