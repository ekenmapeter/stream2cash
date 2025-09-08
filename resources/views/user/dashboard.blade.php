@extends('user.layouts.app')

@section('title', 'Dashboard | Stream2Cash')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow flex flex-col gap-4">
    <!-- User Dashboard Header -->
    <header class="p-6 pt-0">
        <h1 class="text-2xl font-bold mb-1">User Dashboard</h1>
        <p class="text-sm text-black">Welcome back, <span class="font-bold">{{ Auth::user()->name }}!</span> Here's your earning overview.</p>
    </header>
    <div class="flex flex-col lg:flex-row w-full gap-2 bg-[#010E5C] rounded-lg lg:p-4 p-2">
        <div class="flex-1 w-full min-w-0">
    <!-- Stats Section -->
    <section class="grid grid-cols-2 md:grid-cols-2 xl:grid-cols-4 gap-4 mb-4">
        <div class="bg-white p-2 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <i class="text-2xl fa-solid fa-bookmark w-12"></i>
                <div class="text-xs text-gray-400">Available Task</div>
                <div class="text-1xl mt-1 text-black font-bold">{{ $stats['available_tasks'] }}</div>
            </div>
        </div>
        <div class="bg-white p-2 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <i class="text-2xl fa-solid fa-box w-5"></i>
                <div class="text-xs text-gray-400">Complete Task</div>
                <div class="text-1xl text-black font-bold mt-1">{{ $stats['completed_tasks'] }}</div>
            </div>
        </div>
        <div class="bg-white p-2 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <i class="text-2xl fa-solid fa-payroll w-5"></i>
                <div class="text-xs text-gray-400">Withdrawal</div>
                <div class="text-1xl text-black font-bold mt-1">{{ $stats['withdrawals'] }}</div>
            </div>
        </div>
        <div class="bg-white p-2 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <i class="text-2xl fa-solid fa-wallet w-5"></i>
                <div class="text-xs text-gray-400">Wallet Balance</div>
                <div class="text-1xl text-black font-bold mt-1">₦{{ number_format($stats['wallet_balance']) }}</div>
            </div>
        </div>
    </section>

    <!-- Recent History Section -->
    <section class="p-6 rounded-xl text-white shadow-lg mb-4 bg-blue-900">
        <header class="mb-4">
            <h2 class="text-xl font-semibold">Recent History</h2>
            <p class="text-sm">Your latest earning activities and transactions.</p>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 font-bold uppercase text-xs">
                        <th class="py-3 px-4">Name</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_earnings as $earning)
                    <tr class="border-b border-gray-700 text-xs">
                        <td class="py-3 px-4">Earning</td>
                        <td class="py-3 px-4">{{ $earning->source ?? 'Task Completion' }}</td>
                        <td class="py-3 px-4 text-green-400">+₦{{ number_format($earning->amount, 2) }}</td>
                        <td class="py-3 px-4 text-green-400">Completed</td>
                        <td class="py-3 px-4">{{ $earning->created_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-gray-400">No recent earnings found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="text-right mt-4">
            <a href="#" class="text-white font-bold hover:underline">View More</a>
        </div>
    </section>

    <!-- Recent Withdrawal Section -->
    <section class="p-6 rounded-xl shadow-lg text-white  bg-blue-900">
        <header class="mb-4">
            <h2 class="text-xl font-semibold">Recent Withdrawal</h2>
            <p class="text-sm text-gray-400 mt-1">Your recent withdrawal requests and their status.</p>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 font-bold  uppercase text-xs">
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Method</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_withdrawals as $withdrawal)
                    <tr class="border-b border-gray-700 text-xs">
                        <td class="py-3 px-4">₦{{ number_format($withdrawal->amount, 2) }}</td>
                        <td class="py-3 px-4">{{ $withdrawal->method }}</td>
                        <td class="py-3 px-4
                            {{ $withdrawal->status === 'completed' ? 'text-green-400' :
                               ($withdrawal->status === 'pending' ? 'text-yellow-400' : 'text-red-400') }}">
                            {{ ucfirst($withdrawal->status) }}
                        </td>
                        <td class="py-3 px-4">{{ $withdrawal->requested_at->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="py-8 px-4 text-center text-gray-400">No recent withdrawals found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="text-right mt-4">
            <a href="{{ route('user.withdrawal') }}" class="text-white font-bold hover:underline">View More</a>
        </div>
    </section>
        </div>

    <!-- Recent Tasks Sidebar (Right) -->
        <aside class="w-full lg:w-96 flex-shrink-0  bg-blue-900 p-2 rounded-xl shadow-lg h-fit">
            <header class="mb-4">
                <h2 class="text-xl font-semibold text-white">Recent Tasks</h2>
            </header>
            <div class="space-y-4">
                @forelse($recent_tasks as $task)
                <div class="flex items-center space-x-3 bg-white p-4 rounded-xl">
                    <div class="flex-shrink-0">
                        <img src="{{ $task->thumbnail_url ?? 'https://placehold.co/80x80/0000FF/FFFFFF?text=Video' }}" alt="Task thumbnail" class="w-20 h-20 rounded-md object-cover">
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-blue-700">{{ $task->title }}</div>
                        <p class="text-xs text-gray-400 mt-1">{{ Str::limit($task->description, 50) }}</p>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-sm text-yellow-500 font-semibold">₦{{ number_format($task->reward_per_view, 2) }}</span>
                            @if(in_array($task->id, $user_completed_tasks->pluck('video_id')->toArray()))
                                <span class="text-xs text-green-500 font-semibold">Completed</span>
                            @else
                                <span class="text-xs text-red-500 font-semibold">Available</span>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fa-solid fa-tasks text-4xl mb-2"></i>
                    <p>No tasks available</p>
                </div>
                @endforelse
            </div>
            <div class="text-right mt-4">
                <a href="{{ route('user.tasks') }}" class="text-white font-bold hover:underline">View More</a>
            </div>
        </aside>
    </div>
    @include('user.components.footer_link')
</main>


@endsection

