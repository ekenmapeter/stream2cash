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
        <div class="bg-blue-800 rounded-xl shadow-lg overflow-hidden">
            @php $isCompleted = isset($completed_task_ids) && in_array($task->id, $completed_task_ids); @endphp

            @php
                // Check if it's a YouTube URL
                $isYouTube = preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $task->url, $matches);
                $youtubeId = $isYouTube ? $matches[1] : null;
                $thumbnailUrl = $isYouTube ? "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg" : ($task->thumbnail_url ?? $task->thumbnail ?? 'https://placehold.co/600x300/0000FF/FFFFFF?text=Video');
            @endphp

            @if($isCompleted)
                <!-- Completed state - show thumbnail -->
                <img src="{{ $thumbnailUrl }}" alt="{{ $task->title }}" class="w-full h-48 object-cover">
            @else
                <!-- Active state - show video player -->
                <div class="relative w-full h-48 bg-black">
                    @if($isYouTube)
                        <!-- YouTube Player -->
                        <div id="youtube-player-{{ $task->id }}" class="w-full h-full" data-youtube-id="{{ $youtubeId }}"></div>
                        <div id="youtube-loading-{{ $task->id }}" class="absolute inset-0 flex items-center justify-center bg-blue-800">
                            <div class="text-center text-white">
                                <i class="fa-solid fa-spinner fa-spin text-3xl mb-2"></i>
                                <p>Loading video...</p>
                            </div>
                        </div>
                    @else
                        <!-- HTML5 Video Player -->
                        <video
                            id="video-{{ $task->id }}"
                            class="w-full h-full object-cover"
                            controls
                            preload="metadata"
                            data-video-id="{{ $task->id }}"
                            poster="{{ $thumbnailUrl }}"
                        >
                            <source src="{{ $task->url }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @endif

                    <!-- Video completion overlay -->
                    <div id="completion-overlay-{{ $task->id }}" class="absolute inset-0 bg-green-900 bg-opacity-90 items-center justify-center hidden" style="display: none;">
                        <div class="text-center text-white">
                            <i class="fa-solid fa-check-circle text-6xl mb-4"></i>
                            <h3 class="text-2xl font-bold mb-2">Task Completed!</h3>
                            <p class="text-lg">You earned ₦{{ number_format($task->reward_per_view, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-6">
                <h3 class="text-xl text-white font-semibold mb-2">{{ $task->title }}</h3>
                <p class="text-gray-200 text-xs mb-4">{{ Str::limit($task->description, 140) }}</p>
                <div class="flex items-center justify-between mb-4">
                    <span class="text-2xl font-bold text-yellow-500">₦{{ number_format($task->reward_per_view, 2) }}</span>
                    <span class="px-3 py-1 text-xs rounded-full {{ $isCompleted ? 'bg-green-700 text-green-100' : 'bg-red-700 text-red-100' }}">
                        {{ $isCompleted ? 'Completed' : 'Available' }}
                    </span>
                </div>
                @if($isCompleted)
                    <button class="w-full bg-green-700 cursor-not-allowed text-white py-2 px-4 rounded-lg transition-colors" disabled>
                        <i class="fa-solid fa-check mr-2"></i>Completed
                </button>
                @else
                    <a href="{{ route('user.tasks.details', $task) }}" class="w-full bg-blue-700 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors inline-block text-center">
                        <i class="fa-solid fa-play mr-2"></i>View Task
                    </a>
                @endif
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

<!-- YouTube Player API -->
<script src="https://www.youtube.com/iframe_api"></script>

<script>
// Global variables
let currentVideoId = null;
let isTaskInProgress = false;
let youtubePlayers = {};

// YouTube API ready callback
function onYouTubeIframeAPIReady() {
    // Initialize YouTube players for all YouTube videos
    const youtubeContainers = document.querySelectorAll('[id^="youtube-player-"]');
    youtubeContainers.forEach(container => {
        const videoId = container.id.replace('youtube-player-', '');
        const youtubeId = container.dataset.youtubeId;

        if (youtubeId) {
            youtubePlayers[videoId] = new YT.Player(container.id, {
                height: '100%',
                width: '100%',
                videoId: youtubeId,
                playerVars: {
                    'playsinline': 1,
                    'controls': 1,
                    'rel': 0,
                    'modestbranding': 1
                },
                events: {
                    'onReady': function(event) {
                        // Hide loading indicator
                        const loading = document.getElementById(`youtube-loading-${videoId}`);
                        if (loading) {
                            loading.style.display = 'none';
                        }
                    },
                    'onStateChange': function(event) {
                        if (event.data === YT.PlayerState.ENDED && currentVideoId === parseInt(videoId)) {
                            completeVideo(videoId);
                        }
                    },
                    'onError': function(event) {
                        console.error('YouTube player error:', event.data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Video Error',
                            text: 'Error loading YouTube video. Please try again.',
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 5000,
                            timerProgressBar: true
                        });
                        resetTaskState(videoId);
                    }
                }
            });
        }
    });
}

// Function to start a task
function startTask(videoId) {
    if (isTaskInProgress) {
        Swal.fire({
            icon: 'warning',
            title: 'Task in Progress',
            text: 'Please complete the current task before starting a new one.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
        });
        return;
    }

    currentVideoId = videoId;
    isTaskInProgress = true;

    const button = document.getElementById(`task-button-${videoId}`);

    if (button) {
        // Update button state
        button.textContent = 'Task in Progress...';
        button.classList.remove('bg-blue-700', 'hover:bg-blue-600');
        button.classList.add('bg-orange-600', 'cursor-not-allowed');
        button.disabled = true;

        // Check if it's a YouTube video or HTML5 video
        const youtubePlayer = youtubePlayers[videoId];
        const html5Video = document.getElementById(`video-${videoId}`);

        if (youtubePlayer) {
            // Play YouTube video
            youtubePlayer.playVideo();
        } else if (html5Video) {
            // Play HTML5 video
            html5Video.play().catch(error => {
                console.error('Error playing video:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Playback Error',
                    text: 'Error playing video. Please try again.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
                resetTaskState(videoId);
            });
        }
    }
}

// Function to reset task state
function resetTaskState(videoId) {
    isTaskInProgress = false;
    currentVideoId = null;

    const button = document.getElementById(`task-button-${videoId}`);
    if (button) {
        button.textContent = 'Start Task';
        button.classList.remove('bg-orange-600', 'cursor-not-allowed');
        button.classList.add('bg-blue-700', 'hover:bg-blue-600');
        button.disabled = false;
    }
}

// Function to complete video and reward user
function completeVideo(videoId) {
    const overlay = document.getElementById(`completion-overlay-${videoId}`);
    const button = document.getElementById(`task-button-${videoId}`);

    // Show completion overlay
    if (overlay) {
        overlay.style.display = 'flex';
        overlay.classList.remove('hidden');
    }

    // Send completion request to server
    fetch('/api/video-complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            user_id: {{ Auth::id() }},
            video_id: videoId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Update button to completed state
            if (button) {
                button.textContent = 'Completed';
                button.classList.remove('bg-orange-600', 'hover:bg-blue-600');
                button.classList.add('bg-gray-600', 'cursor-not-allowed');
                button.disabled = true;
            }

            // Show success message
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Congratulations!',
                    html: `You earned ₦${data.points.toFixed(2)}!<br>Your new balance is ₦${data.new_balance.toFixed(2)}`,
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });

                // Hide overlay and reload page to show updated state
                if (overlay) {
                    overlay.style.display = 'none';
                    overlay.classList.add('hidden');
                }

                // Reload page to show updated completion status
                window.location.reload();
            }, 2000);

        } else {
            console.error('Error:', data.message);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 5000,
                timerProgressBar: true
            });

            // Hide overlay and reset state
            if (overlay) {
                overlay.style.display = 'none';
                overlay.classList.add('hidden');
            }
            resetTaskState(videoId);
        }
    })
    .catch(error => {
        console.error('Fetch error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Network Error',
            text: 'Please try again.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 5000,
            timerProgressBar: true
        });

        // Hide overlay and reset state
        if (overlay) {
            overlay.style.display = 'none';
            overlay.classList.add('hidden');
        }
        resetTaskState(videoId);
    });

    // Reset global state
    isTaskInProgress = false;
    currentVideoId = null;
}

// Initialize video event listeners on page load
document.addEventListener('DOMContentLoaded', function() {
    // Add event listeners to all HTML5 video elements
    const videos = document.querySelectorAll('video[data-video-id]');
    videos.forEach(video => {
        const videoId = video.dataset.videoId;

        // Add event listener for video completion
        video.addEventListener('ended', function() {
            if (currentVideoId === parseInt(videoId)) {
                completeVideo(videoId);
            }
        });

        // Add event listener for video errors
        video.addEventListener('error', function() {
            if (currentVideoId === parseInt(videoId)) {
                console.error('Video error occurred');
                Swal.fire({
                    icon: 'error',
                    title: 'Video Error',
                    text: 'Error loading video. Please try again.',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 5000,
                    timerProgressBar: true
                });
                resetTaskState(videoId);
            }
        });
    });
});
</script>
@endsection
