@extends('user.layouts.app')

@section('title', 'Profile | Stream2Cash')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow">
    <!-- Profile Header -->
    <header class="p-6 pt-0">
        <h1 class="text-2xl font-bold mb-1">Profile</h1>
        <p class="text-sm text-gray-400">Manage your account information</p>
    </header>

    <!-- Profile Information & Payout Details -->
    <section class="bg-blue-900 text-white p-6 rounded-xl shadow-lg mb-6">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-start">
            <!-- Avatar + Edit -->
            <div class="flex flex-col items-center">
                <div class="w-56 h-56 rounded-full bg-white/10 border-4 border-white/30 flex items-center justify-center overflow-hidden">
                    <i class="fa-solid fa-user text-7xl text-white/70"></i>
                </div>
                <button class="mt-4 bg-white text-blue-900 font-semibold py-2 px-5 rounded-lg">Edit Profile</button>
            </div>
        <div class="grid grid-cols-1 gap-8">
            <!-- Account Details -->
            <div class="lg:col-span-1">
                <h3 class="font-semibold text-lg mb-4">Account Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex"><span class="w-36 text-white/70">Full Name:</span> <span class="font-medium">{{ $user->name }}</span></div>
                    <div class="flex"><span class="w-36 text-white/70">Email:</span> <span class="font-medium">{{ $user->email }}</span></div>
                    <div class="flex"><span class="w-36 text-white/70">Username:</span> <span class="font-medium">{{ $user->username ?? Str::before($user->email, '@') }}</span></div>
                    <div class="flex"><span class="w-36 text-white/70">Last Login:</span> <span class="font-medium">{{ $user->last_login_at ? $user->last_login_at->diffForHumans() : '—' }}</span></div>
                    <div class="flex"><span class="w-36 text-white/70">Status:</span> <span class="font-medium">{{ ucfirst($user->status ?? 'active') }}</span></div>
                </div>
            </div>

            <!-- Payout Details -->
            <div class="lg:col-span-1">
                <h3 class="font-semibold text-lg mb-4">Payout Details</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex"><span class="w-40 text-white/70">Bank Name</span> <span class="font-medium">{{ $lastWithdrawal->bank_name ?? '—' }}</span></div>
                    <div class="flex"><span class="w-40 text-white/70">Account Number</span> <span class="font-medium">{{ $lastWithdrawal->account_details ?? '—' }}</span></div>
                    <div class="flex"><span class="w-40 text-white/70">Account Name</span> <span class="font-medium">{{ $user->name }}</span></div>
                </div>
            </div>
        </div>
        </div>
    </section>

    <!-- Account Statistics -->
    <section class="bg-blue-900 p-6 rounded-xl shadow-lg mb-6 text-white">
        <h2 class="text-xl font-semibold mb-4">Account Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-400">{{ $stats['tasks_completed'] }}</div>
                <div class="text-sm text-gray-400">Tasks Completed</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-400">₦{{ number_format($stats['total_earned'], 2) }}</div>
                <div class="text-sm text-gray-400">Total Earned</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-400">{{ $stats['withdrawals'] }}</div>
                <div class="text-sm text-gray-400">Withdrawals</div>
            </div>
        </div>
    </section>

    <!-- Security Settings -->
    <section class="bg-blue-900 p-6 rounded-xl shadow-lg text-white">
        <h2 class="text-xl font-semibold mb-4">User Activities</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs">
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $a)
                    <tr class="border-b border-gray-700 text-xs">
                        <td class="py-3 px-4 {{ $a['type'] === 'earning' ? 'text-green-400' : 'text-red-400' }}">{{ ucfirst($a['type']) }}</td>
                        <td class="py-3 px-4">{{ $a['description'] }}</td>
                        <td class="py-3 px-4 {{ $a['type'] === 'earning' ? 'text-green-400' : 'text-red-400' }}">{{ $a['type'] === 'earning' ? '+' : '-' }}₦{{ number_format($a['amount'], 2) }}</td>
                        <td class="py-3 px-4 {{ ($a['status'] ?? 'completed') === 'completed' ? 'text-green-400' : 'text-yellow-400' }}">{{ ucfirst($a['status'] ?? 'completed') }}</td>
                        <td class="py-3 px-4">{{ $a['date']?->format('M d, Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 px-4 text-center text-gray-400">No recent activity</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
