@extends('admin.layouts.app')

@section('title', 'Cheating Users | Stream2Cash Admin')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Cheating Users</h1>
            <p class="text-gray-600">Users flagged by anti-cheat with recent attempts</p>
        </div>
        <form method="GET" class="flex items-center gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name or email" class="px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">Search</button>
        </form>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Attempts</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Attempt</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @forelse($userGroups as $group)
                    @php
                        $user = optional($group->user);
                        $list = $attemptsByUser[$group->user_id] ?? collect();
                        $count = $list->count();
                        $last = $count ? $list->first() : null;
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $user->name ?? 'Unknown' }}</div>
                            <div class="text-sm text-gray-500">{{ $user->email ?? '' }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $count }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $last ? $last->created_at->format('M d, Y H:i') : '—' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex items-center gap-3">
                                <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
                                <form method="POST" action="{{ route('admin.users.suspend', $user) }}" onsubmit="return confirmSuspend(this);">
                                    @csrf
                                    <input type="hidden" name="reason" value="Cheating attempts detected by anti-cheat system">
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Suspend User">
                                        <i class="fa-solid fa-ban"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @if($count)
                        <tr class="bg-gray-50">
                            <td colspan="4" class="px-6 py-3">
                                <div class="text-sm text-gray-700">Recent attempts</div>
                                <div class="mt-2 grid md:grid-cols-2 gap-3">
                                    @foreach($list->take(6) as $attempt)
                                        <div class="border rounded p-3">
                                            <div class="text-xs text-gray-500">{{ $attempt->created_at->diffForHumans() }}</div>
                                            <div class="text-sm">Video: {{ optional($attempt->video)->title ?? 'N/A' }} (ID {{ $attempt->video_id }})</div>
                                            <div class="text-xs text-gray-600">Status: {{ ucfirst($attempt->status) }}</div>
                                            <div class="text-xs text-gray-600">Reason: {{ $attempt->reason }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                        </tr>
                    @endif
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">No cheating users found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">
        {{ $userGroups->withQueryString()->links() }}
    </div>
</div>

<script>
function confirmSuspend(form) {
    if (window.Swal) {
        Swal.fire({
            title: 'Suspend User?',
            text: 'This will suspend the user account.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, suspend',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
        return false;
    }
    return confirm('Suspend this user?');
}
</script>
@endsection


