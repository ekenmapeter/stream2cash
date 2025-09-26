@extends('user.layouts.app')

@section('title', 'Withdrawal | StreamAdolla')

@section('content')
<main class="flex-grow flex flex-col p-6 pt-20 gap-6">

    <header>
        <h1 class="text-2xl font-bold mb-1">Withdrawal</h1>
        <p class="text-sm text-gray-600">Request a withdrawal of your earnings</p>
    </header>
    <section class="grid grid-cols-1 md:grid-cols-2 gap-6 text-white">
        <section class="grid grid-cols-1 md:grid-cols-1 gap-6 text-white">
            <div class="bg-blue-800 p-6 rounded-xl shadow-lg flex flex-col items-center">
                <i class="fa-solid fa-sack-dollar text-4xl text-blue-400 mb-3"></i>
                <div class="text-sm text-blue-200">Available Balance</div>
                <div class="text-3xl font-bold mt-1">${{ number_format($withdrawal_data['balance']) }}</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center text-black">
                <i class="fa-solid fa-circle-minus text-4xl text-blue-800 mb-3"></i>
                <div class="text-sm text-gray-500">Minimum Withdrawal</div>
                <div class="text-3xl font-bold mt-1">${{ number_format($withdrawal_data['min_withdrawal']) }}</div>
            </div>

            <div class="bg-white p-6 rounded-xl shadow-lg flex flex-col items-center text-black">
                <i class="fa-solid fa-list-check text-4xl text-blue-800 mb-3"></i>
                <div class="text-sm text-gray-500">Available Methods</div>
                <div class="text-3xl font-bold mt-1">{{ count($withdrawal_data['withdrawal_methods']) }}</div>
            </div>
        </section>

        <section class="bg-blue-900 p-6 rounded-xl shadow-lg text-white">
            <h2 class="text-xl font-semibold mb-4">Request a New Withdrawal</h2>
            @if (session('success'))
                <div class="mb-4 rounded-lg bg-green-600/20 border border-green-500 text-green-100 px-4 py-3">
                    {{ session('success') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="mb-4 rounded-lg bg-red-600/20 border border-red-500 text-red-100 px-4 py-3">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form class="space-y-6" method="POST" action="{{ route('user.withdrawal.request') }}">
                @csrf
                <div>
                    <label for="withdrawal_method" class="block text-sm font-medium text-gray-300 mb-2">Withdrawal Method</label>
                    <select id="withdrawal_method" name="method" class="w-full bg-blue-800 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                        <option value="">Select withdrawal method</option>
                        @foreach($withdrawal_data['withdrawal_methods'] as $method)
                            @if(strtolower($method) !== 'mobile money' && strtolower($method) !== 'mobile_money')
                                <option value="{{ $method }}" @selected(old('method') === $method)>{{ $method }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="amount" class="block text-sm font-medium text-gray-300 mb-2">Amount ($)</label>
                    <input type="number" id="amount" name="amount" min="{{ $withdrawal_data['min_withdrawal'] }}" max="{{ $withdrawal_data['balance'] }}" placeholder="e.g., 5000" value="{{ old('amount') }}" class="w-full bg-blue-800 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                </div>
                <!-- Bank Transfer Details -->
                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                    <div>
                        <label for="bank_name" class="block text-sm font-medium text-gray-300 mb-2">Bank Name</label>
                        <input type="text" id="bank_name" name="bank_name" placeholder="e.g., First Bank" value="{{ old('bank_name') }}" class="w-full bg-blue-800 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div>
                        <label for="account_name" class="block text-sm font-medium text-gray-300 mb-2">Account Name</label>
                        <input type="text" id="account_name" name="account_name" placeholder="e.g., John Doe" value="{{ old('account_name') }}" class="w-full bg-blue-800 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                    <div>
                        <label for="account_number" class="block text-sm font-medium text-gray-300 mb-2">Account Number</label>
                        <input type="text" id="account_number" name="account_number" inputmode="numeric" maxlength="20" placeholder="e.g., 0123456789" value="{{ old('account_number') }}" class="w-full bg-blue-800 border-none rounded-lg px-4 py-3 text-white focus:outline-none focus:ring-2 focus:ring-blue-400" required>
                    </div>
                </div>
                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-semibold py-3 px-4 rounded-lg transition-colors">
                    Request Withdrawal
                </button>
            </form>
        </section>
    </section>
    <section class="bg-blue-900 p-6 rounded-xl shadow-lg text-white">
        <h2 class="text-xl font-semibold mb-4">Withdrawal History</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs">
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Method</th>
                        <th class="py-3 px-4 hidden sm:table-cell">Date</th>
                        <th class="py-3 px-4 text-right">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($withdrawal_data['recent_withdrawals'] as $w)
                        <tr class="border-b border-blue-800">
                            <td class="py-3 px-4 text-sm font-semibold text-red-400">₦{{ number_format($w->amount, 0) }}</td>
                            <td class="py-3 px-4 text-sm">{{ $w->method ?? 'Withdrawal' }}</td>
                            <td class="py-3 px-4 text-sm text-gray-400 hidden sm:table-cell">{{ optional($w->requested_at)->diffForHumans() ?? \Illuminate\Support\Carbon::parse($w->requested_at)->diffForHumans() }}</td>
                            <td class="py-3 px-4 text-sm text-right">
                                @php
                                    $status = strtolower($w->status ?? '');
                                    $badge = match($status) {
                                        'approved' => 'bg-green-700 text-green-100',
                                        'pending' => 'bg-yellow-700 text-yellow-100',
                                        'failed', 'rejected' => 'bg-red-700 text-red-100',
                                        default => 'bg-gray-600 text-gray-100'
                                    };
                                    $label = ucfirst($status ?: 'Unknown');
                                @endphp
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $badge }}">{{ $label }}</span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="py-4 px-4 text-center text-sm text-gray-300">No withdrawals yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
