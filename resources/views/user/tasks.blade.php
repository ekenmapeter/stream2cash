@extends('user.layouts.app')

@section('title', 'Tasks | StreamAdolla')

@section('content')
<main class="flex-grow p-6">
    <header class="mb-8">
        <h1 class="text-3xl font-bold text-black mb-2">Available Tasks</h1>
        <p class="text-black text-lg">Complete tasks to earn money.</p>
    </header>

    <section class="mb-8 bg-blue-900 rounded-2xl p-4 shadow-xl">
        <h2 class="text-sm font-semibold text-white mb-4">Filter & Sort Tasks</h2>
        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title or description"
                   class="w-full bg-white/10 text-white placeholder-white/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

            <input type="number" name="min_reward" value="{{ request('min_reward') }}" placeholder="Min reward"
                   class="w-full bg-white/10 text-white placeholder-white/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

            <input type="number" name="max_reward" value="{{ request('max_reward') }}" placeholder="Max reward"
                   class="w-full bg-white/10 text-white placeholder-white/50 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">

            <select name="sort" class="w-full bg-white/10 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400">
                <option value="latest" class="bg-blue-900" {{ request('sort','latest')==='latest'?'selected':'' }}>Latest</option>
                <option value="oldest" class="bg-blue-900" {{ request('sort')==='oldest'?'selected':'' }}>Oldest</option>
                <option value="reward_high" class="bg-blue-900" {{ request('sort')==='reward_high'?'selected':'' }}>Amount: High to Low</option>
                <option value="reward_low" class="bg-blue-900" {{ request('sort')==='reward_low'?'selected':'' }}>Amount: Low to High</option>
                <option value="views_high" class="bg-blue-900" {{ request('sort')==='views_high'?'selected':'' }}>Views: High to Low</option>
                <option value="views_low" class="bg-blue-900" {{ request('sort')==='views_low'?'selected':'' }}>Views: Low to High</option>
            </select>

            <div class="md:col-span-4 flex gap-3 mt-2">
                <button type="submit" class="w-full md:w-auto bg-blue-700 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200">
                    <i class="fa-solid fa-filter mr-2"></i> Apply Filters
                </button>
                <a href="{{ route('user.tasks') }}" class="w-full md:w-auto bg-white/10 hover:bg-white/20 text-white font-semibold px-6 py-3 rounded-lg transition-colors duration-200 text-center">
                    <i class="fa-solid fa-undo mr-2"></i> Reset
                </a>
            </div>
        </form>
    </section>

    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($tasks as $task)
        <div class="bg-blue-900 rounded-2xl shadow-xl overflow-hidden transform hover:scale-105 transition-transform duration-300">
            @php $isCompleted = isset($completed_task_ids) && in_array($task->id, $completed_task_ids); @endphp

            @php
                // Check if it's a YouTube URL
                $isYouTube = preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/', $task->url, $matches);
                $youtubeId = $isYouTube ? $matches[1] : null;
                $thumbnailUrl = $isYouTube ? "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg" : ($task->thumbnail_url ?? $task->thumbnail ?? 'https://placehold.co/600x300/1E3A8A/FFFFFF?text=Video');
            @endphp

            @if($isCompleted)
                <div class="relative w-full h-48 bg-black">
                    <img src="{{ $thumbnailUrl }}" alt="{{ $task->title }}" class="w-full h-48 object-cover opacity-60" loading="lazy">
                    <div class="absolute inset-0 flex flex-col items-center justify-center bg-black/60 text-white">
                        <i class="fa-solid fa-check-circle text-6xl text-green-500 mb-4"></i>
                        <span class="text-2xl font-bold">Task Completed!</span>
                    </div>
                </div>
            @else
                <div class="relative w-full h-48 bg-black">
                    <div class="absolute inset-0 flex items-center justify-center text-white bg-black/40 pointer-events-none" data-lazy-overlay="{{ $task->id }}">
                        <div class="flex flex-col items-center">
                            <i class="fa-solid fa-spinner fa-spin text-4xl text-blue-500 mb-2"></i>
                            <p class="text-sm">Preparing video...</p>
                        </div>
                    </div>
                    @if($isYouTube)
                        <div id="youtube-player-{{ $task->id }}" class="w-full h-full lazy-youtube" data-youtube-id="{{ $youtubeId }}" data-task-id="{{ $task->id }}"></div>
                    @else
                        <video
                            id="video-{{ $task->id }}"
                            class="w-full h-full object-cover lazy-video"
                            controls
                            preload="none"
                            data-video-id="{{ $task->id }}"
                            poster="{{ $thumbnailUrl }}"
                            data-src="{{ $task->url }}"
                        >
                            </video>
                    @endif

                    <div id="completion-overlay-{{ $task->id }}" class="absolute inset-0 bg-green-900 bg-opacity-90 flex items-center justify-center hidden">
                        <div class="text-center text-white">
                            <i class="fa-solid fa-check-circle text-6xl mb-4"></i>
                            <h3 class="text-2xl font-bold mb-2">Task Completed!</h3>
                            <p class="text-lg">You earned ₦{{ number_format($task->reward_per_view, 2) }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="p-2">
                <h3 class="text-sm text-white font-semibold mb-2">{{ Str::limit($task->title, 35) }}</h3>
                <p class="text-gray-200 text-xs mb-4">{{ Str::limit($task->description, 120) }}</p>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center space-x-2">
                    <span class="text-2xl font-bold text-yellow-500">₦{{ number_format($task->reward_per_view, 2) }}</span>
                    </div>
                    <div class="flex flex-col items-end gap-1 text-right">
                         <div class="flex items-center gap-2">
                            <i class="fa-solid fa-eye text-sm text-white/50"></i>
                            <span class="text-sm text-white/70">{{ $task->watches_count ?? $task->watches()->count() }} views</span>
                        </div>
                        <span class="px-3 py-1 text-xs rounded-full font-semibold {{ $isCompleted ? 'bg-green-700 text-green-100' : 'bg-blue-700 text-blue-100' }}">
                        {{ $isCompleted ? 'Completed' : 'Available' }}
                    </span>
                    </div>
                </div>

                @if($isCompleted)
                    <button class="w-full bg-green-700 text-white py-3 rounded-lg font-semibold transition-colors cursor-not-allowed opacity-70" disabled>
                        <i class="fa-solid fa-check mr-2"></i> Completed
                </button>
                @else
                    <a href="{{ route('user.tasks.details', $task) }}" class="w-full bg-blue-700 hover:bg-blue-600 text-white py-3 rounded-lg font-semibold transition-colors inline-block text-center">
                        <i class="fa-solid fa-play mr-2"></i> View Task
                    </a>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-full text-center py-20 bg-blue-900 rounded-2xl shadow-xl">
            <i class="fa-solid fa-list-check text-6xl text-blue-700 mb-4"></i>
            <h3 class="text-2xl font-semibold text-white mb-2">No Tasks Available</h3>
            <p class="text-white/60">Check back later for new earning opportunities!</p>
        </div>
        @endforelse
    </section>

    @if(method_exists($tasks, 'hasPages') && $tasks->hasPages())
    <div class="mt-8">
        {{ $tasks->links() }}
    </div>
    @endif
</main>

<script src="https://www.youtube.com/iframe_api"></script>

<script>
// Global variables
let currentVideoId = null;
let isTaskInProgress = false;
let youtubePlayers = {};

// YouTube API ready callback (deferred init handled by IntersectionObserver)
function onYouTubeIframeAPIReady() {}

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
    // Lazy load videos and YouTube iframes
    const io = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const taskId = el.dataset.videoId || el.dataset.taskId;
            const overlay = document.querySelector(`[data-lazy-overlay="${taskId}"]`);

            // HTML5 video
            if (el.classList.contains('lazy-video')) {
                const src = el.getAttribute('data-src');
                if (src && !el.querySelector('source')) {
                    const source = document.createElement('source');
                    source.src = src;
                    source.type = 'video/mp4';
                    el.appendChild(source);
                    el.load();
                }
                if (overlay) overlay.style.display = 'none';
                io.unobserve(el);
            }

            // YouTube container
            if (el.classList.contains('lazy-youtube')) {
                const youtubeId = el.dataset.youtubeId;
                const containerId = el.id;
                const videoId = el.dataset.taskId;
                if (youtubeId && typeof YT !== 'undefined' && YT.Player) {
                    youtubePlayers[videoId] = new YT.Player(containerId, {
                        height: '100%',
                        width: '100%',
                        videoId: youtubeId,
                        playerVars: { playsinline: 1, controls: 1, rel: 0, modestbranding: 1 },
                        events: {
                            onReady: function() { if (overlay) overlay.style.display = 'none'; },
                            onStateChange: function(event) {
                                if (event.data === YT.PlayerState.ENDED && currentVideoId === parseInt(videoId)) {
                                    completeVideo(videoId);
                                }
                            },
                            onError: function() {
                                Swal.fire({ icon:'error', title:'Video Error', text:'Error loading YouTube video. Please try again.', toast:true, position:'top-end', showConfirmButton:false, timer:5000, timerProgressBar:true });
                                resetTaskState(videoId);
                            }
                        }
                    });
                    io.unobserve(el);
                }
            }
        });
    }, { rootMargin: '200px 0px', threshold: 0.1 });

    document.querySelectorAll('.lazy-video, .lazy-youtube').forEach(el => io.observe(el));

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
