@extends('admin.layouts.app')

@section('title', 'Suspension Details | Stream2Cash Admin')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Suspension Details</h1>
            <p class="text-gray-600">Review suspension details and take action</p>
        </div>
        <a href="{{ route('admin.suspensions') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to Suspensions
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- User Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">User Information</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->user->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->user->email }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">User ID</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->user->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Account Status</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $suspension->user->status == 'active' ? 'bg-green-100 text-green-800' :
                               ($suspension->user->status == 'suspended' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800') }}">
                            {{ ucfirst($suspension->user->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Video Information -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Video Information</h3>
                @if($suspension->video)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Video Title</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->video->title }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Reward Amount</label>
                        <p class="mt-1 text-sm text-gray-900">₦{{ number_format($suspension->video->reward_per_view, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Video ID</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->video->id }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $suspension->video->status == 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ucfirst($suspension->video->status) }}
                        </span>
                    </div>
                </div>
                @else
                <p class="text-gray-500">Video information not available</p>
                @endif
            </div>

            <!-- Cheating Evidence -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cheating Evidence</h3>
                @if($suspension->cheat_evidence)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Watch Duration</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->cheat_evidence['watch_duration'] ?? 'N/A' }} seconds</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Video Duration</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->cheat_evidence['video_duration'] ?? 'N/A' }} seconds</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Watch Percentage</label>
                        <p class="mt-1 text-sm text-gray-900">{{ number_format($suspension->cheat_evidence['watch_percentage'] ?? 0, 1) }}%</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Seek Count</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->cheat_evidence['seek_count'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Pause Count</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->cheat_evidence['pause_count'] ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Tab Visible</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ ($suspension->cheat_evidence['tab_visible'] ?? false) ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ ($suspension->cheat_evidence['tab_visible'] ?? false) ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Heartbeat Count</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->cheat_evidence['heartbeat_count'] ?? 'N/A' }}</p>
                    </div>
                </div>

                @if(isset($suspension->cheat_evidence['validation_notes']) && is_array($suspension->cheat_evidence['validation_notes']))
                <div class="mt-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Validation Notes</label>
                    <ul class="list-disc list-inside text-sm text-gray-900">
                        @foreach($suspension->cheat_evidence['validation_notes'] as $note)
                        <li>{{ $note }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @else
                <p class="text-gray-500">No evidence data available</p>
                @endif
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Suspension Status -->
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Suspension Status</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <span class="mt-1 inline-flex px-3 py-1 text-sm font-semibold rounded-full
                            {{ $suspension->status == 'pending' ? 'bg-yellow-100 text-yellow-800' :
                               ($suspension->status == 'approved' ? 'bg-green-100 text-green-800' :
                               ($suspension->status == 'rejected' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800')) }}">
                            {{ ucfirst(str_replace('_', ' ', $suspension->status)) }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Type</label>
                        <p class="mt-1 text-sm text-gray-900">{{ ucfirst($suspension->suspension_type) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Amount Involved</label>
                        <p class="mt-1 text-sm text-gray-900">₦{{ number_format($suspension->amount_involved, 2) }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Wallet Credited</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $suspension->wallet_credited ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $suspension->wallet_credited ? 'Yes' : 'No' }}
                        </span>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email Sent</label>
                        <span class="mt-1 inline-flex px-2 py-1 text-xs font-semibold rounded-full
                            {{ $suspension->email_sent ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $suspension->email_sent ? 'Yes' : 'No' }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            @if($suspension->isPending())
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Actions</h3>
                <div class="space-y-3">
                    <form method="POST" action="{{ route('admin.suspensions.approve', $suspension) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg transition-colors"
                                onclick="return confirm('Approve this suspension and credit wallet?')">
                            <i class="fa-solid fa-check mr-2"></i>Approve & Credit Wallet
                        </button>
                    </form>

                    <button onclick="showRejectModal()"
                            class="w-full bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg transition-colors">
                        <i class="fa-solid fa-times mr-2"></i>Reject Suspension
                    </button>

                    @if(!$suspension->wallet_credited)
                    <form method="POST" action="{{ route('admin.suspensions.credit-wallet', $suspension) }}">
                        @csrf
                        @method('PATCH')
                        <button type="submit"
                                class="w-full bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
                            <i class="fa-solid fa-wallet mr-2"></i>Credit Wallet Only
                        </button>
                    </form>
                    @endif
                </div>
            </div>
            @endif

            <!-- Resolution Details -->
            @if($suspension->resolved_at)
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Resolution Details</h3>
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Resolved At</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->resolved_at->format('M d, Y H:i') }}</p>
                    </div>
                    @if($suspension->resolvedBy)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Resolved By</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->resolvedBy->name }}</p>
                    </div>
                    @endif
                    @if($suspension->admin_notes)
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Admin Notes</label>
                        <p class="mt-1 text-sm text-gray-900">{{ $suspension->admin_notes }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden z-50">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-lg max-w-md w-full p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Reject Suspension</h3>
            <form method="POST" action="{{ route('admin.suspensions.reject', $suspension) }}">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Reason for rejection</label>
                    <textarea name="admin_notes" rows="4" required
                              class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                              placeholder="Please provide a reason for rejecting this suspension..."></textarea>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="hideRejectModal()"
                            class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-md">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 hover:bg-red-700 rounded-md">
                        Reject Suspension
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function showRejectModal() {
    document.getElementById('rejectModal').classList.remove('hidden');
}

function hideRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endsection
