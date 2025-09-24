@extends('user.layouts.app')

@section('title', 'Watch Task: ' . $task->title . ' | StreamAdolla')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow pt-20">
    <!-- Back Button -->
    <div class="p-6 pt-0">
        <a href="{{ route('user.tasks.details', $task) }}" class="inline-flex items-center text-blue-400 hover:text-blue-300 transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>
            Back to Task Details
        </a>
    </div>

    <div class="px-6 pb-6">
        <div class="max-w-4xl mx-auto">
            <!-- Task Header -->
            <div class="text-center mb-8 bg-blue-700 rounded-lg p-4">
                <h1 class="text-3xl text-white font-bold mb-2">{{ $task->title }}</h1>
                <p class="text-gray-200 mb-4">{{ Str::limit($task->description, 100) }}</p>
                <div class="flex items-center justify-center space-x-6">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-500">₦{{ number_format($task->reward_per_view, 2) }}</div>
                        <div class="text-sm text-gray-200">Reward</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-500" id="countdown-timer">{{ $videoSettings['countdown_duration'] }}</div>
                        <div class="text-sm text-gray-200">Seconds</div>
                    </div>
                </div>
            </div>

            <!-- Video Container -->
            <div class="bg-blue-800 rounded-xl shadow-lg overflow-hidden">
                <div class="relative aspect-video bg-black">
                    <!-- Countdown Overlay -->
                    <div id="countdown-overlay" class="absolute inset-0 bg-blue-900 bg-opacity-95 flex items-center justify-center z-10">
                        <div class="text-center text-white">
                            <div class="text-8xl font-bold mb-4" id="countdown-number">{{ $videoSettings['countdown_duration'] }}</div>
                            <h3 class="text-2xl font-semibold mb-2">Get Ready!</h3>
                            <p class="text-gray-300">The video will start in <span id="countdown-text">{{ $videoSettings['countdown_duration'] }}</span> seconds</p>
                        </div>
                    </div>

                    <!-- Video Player -->
                    <div id="video-container" class="absolute inset-0 hidden">
                        @if($isYouTube)
                            <!-- YouTube Player -->
                            <div id="youtube-player" class="w-full h-full"></div>
                        @else
                            <!-- HTML5 Video Player -->
                            <video
                                id="video-player"
                                class="w-full h-full object-cover"
                                controls
                                preload="metadata"
                                poster="{{ $thumbnailUrl }}"
                            >
                                <source src="{{ $task->url }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        @endif
                    </div>

                    <!-- Video completion overlay -->
                    <div id="completion-overlay" class="absolute inset-0 bg-green-900 bg-opacity-90 items-center justify-center hidden" style="display: none;">
                        <div class="text-center text-white">
                            <i class="fa-solid fa-check-circle text-8xl mb-6"></i>
                            <h3 class="text-4xl font-bold mb-4">Task Completed!</h3>
                            <p class="text-2xl mb-6">You earned ₦{{ number_format($task->reward_per_view, 2) }}</p>
                            <div class="space-x-4">
                                <a href="{{ route('user.tasks') }}" class="bg-blue-700 hover:bg-blue-600 text-white py-3 px-6 rounded-lg transition-colors inline-block">
                                    <i class="fa-solid fa-list mr-2"></i>View All Tasks
                                </a>
                                <a href="{{ route('user.tasks.details', $task) }}" class="bg-gray-700 hover:bg-gray-600 text-white py-3 px-6 rounded-lg transition-colors inline-block">
                                    <i class="fa-solid fa-info-circle mr-2"></i>Task Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Video Controls -->
                <div class="p-6">
                    <div class="space-y-4">
                        <!-- Main instruction -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-4">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-play text-blue-400"></i>
                                    <span class="text-sm text-gray-200">Watch the entire video to earn your reward</span>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2">
                                <i class="fa-solid fa-shield-alt text-green-400"></i>
                                <span class="text-sm text-gray-200">Secure & Verified</span>
                            </div>
                        </div>

                        <!-- Anti-cheat requirements -->
                        <div class="bg-blue-700 rounded-lg p-4">
                            <h4 class="text-sm font-semibold text-yellow-400 mb-2">
                                <i class="fa-solid fa-exclamation-triangle mr-1"></i>
                                Important: To earn your reward, you must:
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-xs text-gray-200">
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-check text-green-400"></i>
                                    <span>Watch at least 85% of the video</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-check text-green-400"></i>
                                    <span>Keep this tab visible and active</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-check text-green-400"></i>
                                    <span>Limit seeking to 3 times maximum</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <i class="fa-solid fa-check text-green-400"></i>
                                    <span>Limit pausing to 5 times maximum</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<!-- YouTube Player API -->
@if($isYouTube)
<script src="https://www.youtube.com/iframe_api"></script>
@endif


<script>
// Global variables
let countdownInterval;
let youtubePlayer;
let isVideoStarted = false;
let isTaskInProgress = false;

// Anti-cheat variables
let watchStartTime = null;
let videoDuration = 0;
let watchDuration = 0;
let seekCount = 0;
let pauseCount = 0;
let heartbeatCount = 0;
let isTabVisible = true;
let watchEvents = [];
let heartbeatInterval;
let lastHeartbeatTime = Date.now();
let minimumWatchPercentage = 85; // User must watch at least 85% of video
let maximumSeekCount = {{ $videoSettings['allow_seeking'] ? '999' : '0' }}; // Based on settings
let maximumPauseCount = {{ $videoSettings['allow_pausing'] ? '999' : '0' }}; // Based on settings
let heartbeatIntervalMs = {{ $videoSettings['heartbeat_interval'] * 1000 }}; // Convert to milliseconds

// Countdown function
function startCountdown() {
    let countdown = {{ $videoSettings['countdown_duration'] }};

    function updateCountdown() {
        document.getElementById('countdown-number').textContent = countdown;
        document.getElementById('countdown-text').textContent = countdown;

        if (countdown <= 0) {
            clearInterval(countdownInterval);
            startVideo();
        }
        countdown--;
    }

    updateCountdown(); // Show 5 immediately
    countdownInterval = setInterval(updateCountdown, 1000);
}

// Anti-cheat functions
function startHeartbeat() {
    heartbeatInterval = setInterval(() => {
        if (isTaskInProgress && isTabVisible) {
            heartbeatCount++;
            lastHeartbeatTime = Date.now();

            // Send heartbeat to server
            sendHeartbeat();
        }
    }, heartbeatIntervalMs);
}

function sendHeartbeat() {
    fetch('/api/video-heartbeat', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            user_id: {{ Auth::id() }},
            video_id: {{ $task->id }},
            current_time: watchDuration,
            seek_count: seekCount,
            pause_count: pauseCount,
            tab_visible: isTabVisible
        })
    }).catch(error => {
        console.error('Heartbeat error:', error);
    });
}

function logWatchEvent(eventType, data = {}) {
    watchEvents.push({
        timestamp: Date.now(),
        type: eventType,
        data: data
    });
}

function validateWatchSession() {
    const watchPercentage = videoDuration > 0 ? (watchDuration / videoDuration) * 100 : 0;

    let isValid = true;
    let validationNotes = [];

    // Check minimum watch percentage
    if (watchPercentage < minimumWatchPercentage) {
        isValid = false;
        validationNotes.push(`Watched only ${watchPercentage.toFixed(1)}% of video (minimum ${minimumWatchPercentage}% required)`);
    }

    // Check seek count
    if (seekCount > maximumSeekCount) {
        isValid = false;
        validationNotes.push(`Too many seeks: ${seekCount} (maximum ${maximumSeekCount} allowed)`);
    }

    // Check pause count
    if (pauseCount > maximumPauseCount) {
        isValid = false;
        validationNotes.push(`Too many pauses: ${pauseCount} (maximum ${maximumPauseCount} allowed)`);
    }

    // Check tab visibility
    if (!isTabVisible) {
        isValid = false;
        validationNotes.push('Tab was not visible during video playback');
    }

    // Check heartbeat frequency
    const expectedHeartbeats = Math.floor(watchDuration / (heartbeatIntervalMs / 1000));
    if (heartbeatCount < expectedHeartbeats * 0.7) { // Allow 30% tolerance
        isValid = false;
        validationNotes.push('Insufficient heartbeat activity detected');
    }

    return { isValid, validationNotes };
}

// Tab visibility detection
document.addEventListener('visibilitychange', function() {
    isTabVisible = !document.hidden;
    logWatchEvent('tab_visibility_change', { visible: isTabVisible });
});

// Start video function
function startVideo() {
    const countdownOverlay = document.getElementById('countdown-overlay');
    const videoContainer = document.getElementById('video-container');

    // Hide countdown overlay
    countdownOverlay.style.display = 'none';
    videoContainer.classList.remove('hidden');

    // Initialize anti-cheat tracking
    watchStartTime = Date.now();
    startHeartbeat();

    @if($isYouTube)
        // Initialize YouTube player
        if (typeof YT !== 'undefined' && YT.Player) {
            youtubePlayer = new YT.Player('youtube-player', {
                height: '100%',
                width: '100%',
                videoId: '{{ $youtubeId }}',
                playerVars: {
                    'playsinline': 1,
                    'controls': 1,
                    'rel': 0,
                    'modestbranding': 1
                },
                events: {
                    'onReady': function(event) {
                        // Get video duration
                        videoDuration = event.target.getDuration();
                        logWatchEvent('video_ready', { duration: videoDuration });

                        event.target.playVideo();
                        isVideoStarted = true;
                        isTaskInProgress = true;
                        logWatchEvent('video_started');
                    },
                    'onStateChange': function(event) {
                        const currentTime = event.target.getCurrentTime();
                        watchDuration = Math.floor(currentTime);

                        if (event.data === YT.PlayerState.PAUSED) {
                            pauseCount++;
                            logWatchEvent('video_paused', { currentTime: currentTime });
                        } else if (event.data === YT.PlayerState.PLAYING) {
                            logWatchEvent('video_playing', { currentTime: currentTime });
                        } else if (event.data === YT.PlayerState.ENDED && isTaskInProgress) {
                            logWatchEvent('video_ended');
                            completeVideo();
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
                        resetVideo();
                    }
                }
            });
        }
    @else
        // Play HTML5 video
        const video = document.getElementById('video-player');

        // Get video duration when metadata is loaded
        video.addEventListener('loadedmetadata', function() {
            videoDuration = Math.floor(video.duration);
            logWatchEvent('video_ready', { duration: videoDuration });
        });

        // Track video events
        video.addEventListener('play', function() {
            logWatchEvent('video_playing', { currentTime: video.currentTime });
        });

        video.addEventListener('pause', function() {
            pauseCount++;
            logWatchEvent('video_paused', { currentTime: video.currentTime });
        });

        video.addEventListener('seeked', function() {
            seekCount++;
            logWatchEvent('video_seeked', {
                from: video.previousTime || 0,
                to: video.currentTime
            });
        });

        video.addEventListener('timeupdate', function() {
            watchDuration = Math.floor(video.currentTime);
        });

        video.addEventListener('ended', function() {
            logWatchEvent('video_ended');
            if (isTaskInProgress) {
                completeVideo();
            }
        });

        video.addEventListener('error', function() {
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
            resetVideo();
        });

        video.play().then(() => {
            isVideoStarted = true;
            isTaskInProgress = true;
            logWatchEvent('video_started');
        }).catch(error => {
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
            resetVideo();
        });
    @endif
}

// Complete video function
function completeVideo() {
    // Stop heartbeat
    if (heartbeatInterval) {
        clearInterval(heartbeatInterval);
    }

    // Validate watch session
    const validation = validateWatchSession();

    if (!validation.isValid) {
        // Show validation error
        Swal.fire({
            icon: 'error',
            title: 'Validation Failed',
            html: 'Video completion validation failed:<br><br>' + validation.validationNotes.join('<br>') + '<br><br>Please watch the video properly to earn your reward.',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 8000,
            timerProgressBar: true
        });
        resetVideo();
        return;
    }

    const overlay = document.getElementById('completion-overlay');

    // Show completion overlay
    overlay.style.display = 'flex';
    overlay.classList.remove('hidden');

    // Send completion request to server with detailed tracking data
    fetch('/api/video-complete', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            user_id: {{ Auth::id() }},
            video_id: {{ $task->id }},
            watch_duration: watchDuration,
            video_duration: videoDuration,
            watch_percentage: videoDuration > 0 ? (watchDuration / videoDuration) * 100 : 0,
            seek_count: seekCount,
            pause_count: pauseCount,
            heartbeat_count: heartbeatCount,
            tab_visible: isTabVisible,
            watch_events: watchEvents,
            is_valid: validation.isValid,
            validation_notes: validation.validationNotes
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
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
            }, 1000);
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
            resetVideo();
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
        resetVideo();
    });

    isTaskInProgress = false;
}

// Reset video function
function resetVideo() {
    isVideoStarted = false;
    isTaskInProgress = false;

    // Stop heartbeat
    if (heartbeatInterval) {
        clearInterval(heartbeatInterval);
    }

    // Reset anti-cheat variables
    watchStartTime = null;
    videoDuration = 0;
    watchDuration = 0;
    seekCount = 0;
    pauseCount = 0;
    heartbeatCount = 0;
    isTabVisible = true;
    watchEvents = [];

    // Show countdown overlay again
    const countdownOverlay = document.getElementById('countdown-overlay');
    const videoContainer = document.getElementById('video-container');

    countdownOverlay.style.display = 'flex';
    videoContainer.classList.add('hidden');

    // Reset countdown
    document.getElementById('countdown-number').textContent = '5';
    document.getElementById('countdown-text').textContent = '5';

    // Restart countdown
    startCountdown();
}

// Initialize when page loads
document.addEventListener('DOMContentLoaded', function() {
    // Start countdown immediately
    startCountdown();
});

// YouTube API ready callback
@if($isYouTube)
function onYouTubeIframeAPIReady() {
    // This will be handled by the startVideo function
}
@endif
</script>
@endsection
