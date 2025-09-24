@extends('user.layouts.app')

@section('title', 'Wallet | StreamAdolla')

@section('content')
<main class="flex-grow flex flex-col p-6 pt-0 gap-6">

    <header>
        <h1 class="text-2xl font-bold mb-1">Wallet</h1>
        <p class="text-sm text-gray-600">Manage your earnings and withdrawals</p>
    </header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-blue-800 p-8 rounded-xl flex flex-col justify-between items-start shadow-lg text-white col-span-1 lg:col-span-2">
            <div class="flex items-center gap-4">
                <div class="bg-green-700 p-4 rounded-full text-white text-xl">
                    <i class="fa-solid fa-wallet"></i>
                </div>
                <div>
                    <div class="text-sm text-blue-200">Available Balance</div>
                    <div class="text-4xl font-extrabold mt-1">₦{{ number_format($wallet_data['balance']) }}</div>
                </div>
            </div>
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <a href="{{ route('user.withdrawal') }}" class="bg-white text-blue-800 font-semibold py-3 px-6 rounded-lg flex items-center justify-center gap-2 transition-colors hover:bg-gray-200">
                    Withdraw Funds
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
                <a href="{{ route('user.tasks') }}" class="bg-white text-blue-800 font-semibold py-3 px-6 rounded-lg flex items-center justify-center gap-2 transition-colors hover:bg-gray-200">
                    Earn More
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        </div>

        <div class="flex flex-col gap-4">
            <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-lg">
                <div>
                    <div class="text-sm text-gray-500">Pending Balance</div>
                    <div class="text-2xl font-bold mt-1 text-black">₦{{ number_format($wallet_data['pending']) }}</div>
                </div>
                <div class="bg-yellow-700 p-4 rounded-full text-white text-xl opacity-80">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-lg">
                <div>
                    <div class="text-sm text-gray-500">Total Earned</div>
                    <div class="text-2xl font-bold mt-1 text-black">₦{{ number_format($wallet_data['total_earned']) }}</div>
                </div>
                <div class="bg-blue-700 p-4 rounded-full text-white text-xl opacity-80">
                    <i class="fa-solid fa-chart-line"></i>
                </div>
            </div>
        </div>
    </div>

    <section class="bg-blue-900 text-white p-6 rounded-xl shadow-lg">
        <header class="mb-4">
            <h2 class="text-xl font-semibold">Transaction History</h2>
            <p class="text-sm text-gray-400">All your earnings and withdrawals in one place.</p>
        </header>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs">
                        <th class="py-3 px-4">Type</th>
                        <th class="py-3 px-4">Description</th>
                        <th class="py-3 px-4 text-right">Amount</th>
                        <th class="py-3 px-4 hidden sm:table-cell">Status</th>
                        <th class="py-3 px-4 hidden md:table-cell">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $transactions = $recent_earnings->map(function($item) {
                            $item['type'] = 'earning';
                            return $item;
                        })->concat($recent_withdrawals->map(function($item) {
                            $item['type'] = 'withdrawal';
                            return $item;
                        }))->sortByDesc('created_at');
                    @endphp

                    @forelse($transactions as $transaction)
                        <tr class="border-b border-blue-800 text-sm">
                            <td class="py-3 px-4 text-sm font-semibold {{ $transaction['type'] === 'earning' ? 'text-green-400' : 'text-red-400' }}">
                                {{ ucfirst($transaction['type']) }}
                            </td>
                            <td class="py-3 px-4">
                                @if($transaction['type'] === 'earning')
                                    {{ $transaction->source ?? 'Task Completion' }}
                                @else
                                    {{ $transaction->method }}
                                @endif
                            </td>
                            <td class="py-3 px-4 text-right font-semibold {{ $transaction['type'] === 'earning' ? 'text-green-400' : 'text-red-400' }}">
                                @if($transaction['type'] === 'earning')
                                    +₦{{ number_format($transaction->amount, 2) }}
                                @else
                                    -₦{{ number_format($transaction->amount, 2) }}
                                @endif
                            </td>
                            <td class="py-3 px-4 hidden sm:table-cell">
                                @if($transaction['type'] === 'earning')
                                    <span class="px-2 py-1 rounded-full text-xs font-medium bg-green-700 text-green-100">Completed</span>
                                @else
                                    <span class="px-2 py-1 rounded-full text-xs font-medium
                                        {{ $transaction->status === 'completed' ? 'bg-green-700 text-green-100' :
                                           ($transaction->status === 'pending' ? 'bg-yellow-700 text-yellow-100' : 'bg-red-700 text-red-100') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-3 px-4 hidden md:table-cell text-gray-400">
                                {{ $transaction->created_at->format('M d, Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-8 px-4 text-center text-gray-400">No transactions found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
