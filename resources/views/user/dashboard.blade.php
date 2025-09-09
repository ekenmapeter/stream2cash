@extends('user.layouts.app')

@section('title', 'Dashboard | Stream2Cash')

@section('content')
<main class="flex-grow flex flex-col p-6 pt-0 gap-6">

    <header>
        <h1 class="text-2xl font-bold mb-1">User Dashboard</h1>
        <p class="text-sm text-gray-600">Welcome back, <span class="font-bold">{{ Auth::user()->name }}!</span> Here's your earning overview.</p>
    </header>

    <div class="flex flex-col lg:flex-row w-full gap-6">

        <div class="flex-1 min-w-0">

            <section class="grid grid-cols-2 lg:grid-cols-2 gap-4 mb-6">
                <div class="bg-blue-800 p-6 rounded-xl flex items-center justify-between shadow-lg text-white">
                    <div>
                        <div class="text-sm text-blue-200">Wallet Balance</div>
                        <div class="text-1xl mt-2 font-extrabold">₦{{ number_format($stats['wallet_balance']) }}</div>
                    </div>
                    <i class="text-4xl fa-solid fa-wallet text-blue-400 opacity-70"></i>
                </div>

                <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-lg">
                    <div>
                        <div class="text-sm text-gray-500">Available Tasks</div>
                        <div class="text-1xl mt-2 font-extrabold text-black">{{ $stats['available_tasks'] }}</div>
                    </div>
                    <i class="text-3xl fa-solid fa-bookmark text-blue-800 opacity-70"></i>
                </div>

                <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-lg">
                    <div>
                        <div class="text-sm text-gray-500">Completed Tasks</div>
                        <div class="text-1xl mt-2 font-extrabold text-black">{{ $stats['completed_tasks'] }}</div>
                    </div>
                    <i class="text-3xl fa-solid fa-box-archive text-blue-800 opacity-70"></i>
                </div>

                <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-lg">
                    <div>
                        <div class="text-sm text-gray-500">Withdrawals</div>
                        <div class="text-1xl mt-2 font-extrabold text-black">{{ $stats['withdrawals'] }}</div>
                    </div>
                    <i class="text-3xl fa-solid fa-money-bill-transfer text-blue-800 opacity-70"></i>
                </div>
            </section>

            <section class="bg-blue-900 rounded-xl shadow-lg p-6 mb-6">
                <header class="mb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-white">Recent Earnings</h2>
                        <p class="text-sm text-gray-400 mt-1">Your latest earning activities and transactions.</p>
                    </div>
                    <a href="" class="text-sm text-white hover:underline font-bold">View All</a>
                </header>
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs">
                                <th class="py-3 px-2">Type</th>
                                <th class="py-3 px-2">Source</th>
                                <th class="py-3 px-2 text-right">Amount</th>
                                <th class="py-3 px-2 hidden sm:table-cell">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_earnings as $earning)
                                <tr class="border-t border-blue-800 text-sm text-white">
                                    <td class="py-3 px-2">Earning</td>
                                    <td class="py-3 px-2">{{ $earning->source ?? 'Task Completion' }}</td>
                                    <td class="py-3 px-2 text-right text-green-400 font-semibold">+₦{{ number_format($earning->amount, 2) }}</td>
                                    <td class="py-3 px-2 hidden sm:table-cell text-gray-400">{{ $earning->created_at->format('M d, Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400">No recent earnings found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            <section class="bg-blue-900 rounded-xl shadow-lg p-6">
                <header class="mb-4 flex justify-between items-center">
                    <div>
                        <h2 class="text-xl font-semibold text-white">Recent Withdrawals</h2>
                        <p class="text-sm text-gray-400 mt-1">Your recent withdrawal requests and their status.</p>
                    </div>
                    <a href="{{ route('user.withdrawal') }}" class="text-sm text-white hover:underline font-bold">View All</a>
                </header>
                <div class="overflow-x-auto">
                    <table class="w-full text-left table-auto">
                        <thead>
                            <tr class="text-gray-400 uppercase text-xs">
                                <th class="py-3 px-2">Amount</th>
                                <th class="py-3 px-2">Method</th>
                                <th class="py-3 px-2 hidden sm:table-cell">Date</th>
                                <th class="py-3 px-2 text-right">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recent_withdrawals as $withdrawal)
                                <tr class="border-t border-blue-800 text-sm text-white">
                                    <td class="py-3 px-2 font-semibold">₦{{ number_format($withdrawal->amount, 2) }}</td>
                                    <td class="py-3 px-2">{{ $withdrawal->method }}</td>
                                    <td class="py-3 px-2 hidden sm:table-cell text-gray-400">{{ $withdrawal->created_at->format('M d, Y') }}</td>
                                    <td class="py-3 px-2 text-right">
                                        <span class="px-2 py-1 rounded-full text-xs font-medium
                                            {{ $withdrawal->status === 'completed' ? 'bg-green-700 text-green-100' :
                                               ($withdrawal->status === 'pending' ? 'bg-yellow-700 text-yellow-100' : 'bg-red-700 text-red-100') }}">
                                            {{ ucfirst($withdrawal->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="py-8 text-center text-gray-400">No recent withdrawals found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>

        <aside class="w-full lg:w-80 flex-shrink-0  p-2 rounded-xl h-fit">
            <header class="mb-6">
                <h2 class="text-xl font-semibold text-blue-800">Recent Tasks</h2>
                <p class="text-sm text-gray-600 mt-1">Your latest earning opportunities.</p>
            </header>
            <div class="space-y-4">
                @forelse($recent_tasks as $task)
                <a href="{{ route('user.tasks.details', $task) }}" class="block">
                    <div class="flex items-center space-x-4 bg-white p-3 rounded-xl hover:bg-gray-100 transition-colors shadow-lg ">
                        <div class="flex-shrink-0">
                            <img src="{{ $task->thumbnail_url ?? 'https://placehold.co/80x80/0000FF/FFFFFF?text=Video' }}" alt="Task thumbnail" class="w-16 h-16 rounded-lg object-cover">
                        </div>
                        <div class="flex-grow">
                            <div class="text-sm font-semibold text-blue-700">{{ $task->title }}</div>
                            <p class="text-xs text-gray-700 mt-1">{{ Str::limit($task->description, 50) }}</p>
                            <div class="flex items-center justify-between mt-2">
                                <span class="text-sm text-yellow-500 font-bold">₦{{ number_format($task->reward_per_view, 2) }}</span>
                                @if(in_array($task->id, $user_completed_tasks->pluck('video_id')->toArray()))
                                    <span class="text-xs text-green-600 font-semibold">Completed</span>
                                @else
                                    <span class="text-xs text-red-600 font-semibold">Available</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <div class="text-center py-8 text-gray-400">
                    <i class="fa-solid fa-list-check text-4xl mb-2"></i>
                    <p>No recent tasks found.</p>
                </div>
                @endforelse
            </div>
            <div class="text-center mt-6">
                <a href="{{ route('user.tasks') }}" class="inline-block text-white font-bold hover:underline">View All Tasks</a>
            </div>
        </aside>
    </div>
    @include('user.components.footer_link')
</main>
@endsection
