@extends('user.layouts.app')

@section('title', 'Profile | Stream2Cash')

@section('content')
<main class="flex-grow flex flex-col p-6 pt-0 gap-6">

    <header>
        <h1 class="text-2xl font-bold mb-1">Profile</h1>
        <p class="text-sm text-gray-600">Manage your account information</p>
    </header>

    <section class="bg-blue-900 text-white p-6 rounded-xl shadow-lg">
        <div class="flex flex-col md:flex-row gap-8 items-center md:items-start">
            <div class="flex flex-col items-center flex-shrink-0">
                <div class="w-40 h-40 rounded-full bg-white/10 border-4 border-white/30 flex items-center justify-center overflow-hidden">
                    <i class="fa-solid fa-user text-6xl text-white/70"></i>
                </div>
                <button class="mt-4 bg-white text-blue-900 font-semibold py-2 px-6 rounded-lg shadow-md transition-colors hover:bg-gray-200">
                    Edit Profile
                </button>
            </div>

            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-x-12">
                <div>
                    <h3 class="font-semibold text-lg mb-4 text-white">Account Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-36 text-white/70 font-medium">Full Name:</span>
                            <span class="font-bold">{{ $user->name }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-36 text-white/70 font-medium">Email:</span>
                            <span class="font-bold">{{ $user->email }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-36 text-white/70 font-medium">Username:</span>
                            <span class="font-bold">{{ $user->username ?? Str::before($user->email, '@') }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-36 text-white/70 font-medium">Last Login:</span>
                            <span class="font-bold">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '—' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-36 text-white/70 font-medium">Status:</span>
                            <span class="font-bold">{{ ucfirst($user->status ?? 'active') }}</span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="font-semibold text-lg mb-4 text-white">Payout Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-40 text-white/70 font-medium">Bank Name:</span>
                            <span class="font-bold">{{ $lastWithdrawal->bank_name ?? '—' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-40 text-white/70 font-medium">Account Number:</span>
                            <span class="font-bold">{{ $lastWithdrawal->account_details ?? '—' }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row sm:items-center">
                            <span class="w-40 text-white/70 font-medium">Account Name:</span>
                            <span class="font-bold">{{ $user->name }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-blue-900 p-6 rounded-xl shadow-lg text-white">
        <h2 class="text-xl font-semibold mb-6">Account Statistics</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            <div class="bg-white/10 p-4 rounded-lg text-center">
                <div class="text-4xl font-extrabold text-blue-400 mb-1">{{ $stats['tasks_completed'] }}</div>
                <div class="text-sm text-gray-300">Tasks Completed</div>
            </div>
            <div class="bg-white/10 p-4 rounded-lg text-center">
                <div class="text-4xl font-extrabold text-green-400 mb-1">₦{{ number_format($stats['total_earned'], 2) }}</div>
                <div class="text-sm text-gray-300">Total Earned</div>
            </div>
            <div class="bg-white/10 p-4 rounded-lg text-center">
                <div class="text-4xl font-extrabold text-yellow-400 mb-1">{{ $stats['withdrawals'] }}</div>
                <div class="text-sm text-gray-300">Withdrawals</div>
            </div>
        </div>
    </section>

    <section class="bg-blue-900 p-6 rounded-xl shadow-lg text-white">
        <h2 class="text-xl font-semibold mb-4">User Activities</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs">
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4 hidden sm:table-cell">Status</th>
                        <th class="py-3 px-4 hidden md:table-cell">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $a)
                        <tr class="border-b border-blue-800 text-sm">
                            <td class="py-3 px-4 font-semibold {{ $a['type'] === 'earning' ? 'text-green-400' : 'text-red-400' }}">{{ ucfirst($a['type']) }}</td>
                            <td class="py-3 px-4">{{ $a['description'] }}</td>
                            <td class="py-3 px-4 font-semibold {{ $a['type'] === 'earning' ? 'text-green-400' : 'text-red-400' }}">{{ $a['type'] === 'earning' ? '+' : '-' }}₦{{ number_format($a['amount'], 2) }}</td>
                            <td class="py-3 px-4 hidden sm:table-cell">
                                <span class="px-2 py-1 rounded-full text-xs font-medium
                                    {{ ($a['status'] ?? 'completed') === 'completed' ? 'bg-green-700 text-green-100' :
                                       'bg-yellow-700 text-yellow-100' }}">
                                    {{ ucfirst($a['status'] ?? 'completed') }}
                                </span>
                            </td>
                            <td class="py-3 px-4 hidden md:table-cell text-gray-400">{{ $a['date']?->format('M d, Y') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-400">No recent activity.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
