@extends('user.layouts.app')

@section('title', 'Withdrawal | Stream2Cash')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow">
    <!-- Withdrawal Header -->
    <header class="p-6 pt-0">
        <h1 class="text-2xl font-bold mb-1">Withdrawal</h1>
        <p class="text-sm text-gray-400">Request a withdrawal of your earnings</p>
    </header>

    <!-- Balance Overview -->
    <section class="bg-gray-800 p-6 rounded-xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Balance Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-green-400">₪{{ number_format($withdrawal_data['balance']) }}</div>
                <div class="text-sm text-gray-400">Available Balance</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-400">₪{{ number_format($withdrawal_data['min_withdrawal']) }}</div>
                <div class="text-sm text-gray-400">Minimum Withdrawal</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-400">{{ count($withdrawal_data['withdrawal_methods']) }}</div>
                <div class="text-sm text-gray-400">Available Methods</div>
            </div>
        </div>
    </section>

    <!-- Withdrawal Form -->
    <section class="bg-gray-800 p-6 rounded-xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Request Withdrawal</h2>
        <form class="space-y-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Withdrawal Method</label>
                <select class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white">
                    <option value="">Select withdrawal method</option>
                    @foreach($withdrawal_data['withdrawal_methods'] as $method)
                    <option value="{{ $method }}">{{ $method }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Amount</label>
                <input type="number" min="{{ $withdrawal_data['min_withdrawal'] }}" max="{{ $withdrawal_data['balance'] }}" placeholder="Enter amount" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Account Details</label>
                <textarea placeholder="Enter your account details (account number, etc.)" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white h-24"></textarea>
            </div>
            <button type="submit" class="w-full bg-blue-700 hover:bg-blue-600 text-white py-3 px-4 rounded-lg transition-colors">
                Request Withdrawal
            </button>
        </form>
    </section>

    <!-- Withdrawal History -->
    <section class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Withdrawal History</h2>
        <div class="overflow-x-auto">
            <table class="w-full text-left table-auto">
                <thead>
                    <tr class="text-gray-400 uppercase text-xs">
                        <th class="py-3 px-4">Amount</th>
                        <th class="py-3 px-4">Method</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Date</th>
                        <th class="py-3 px-4">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-4">₪5,000</td>
                        <td class="py-3 px-4">Bank Transfer</td>
                        <td class="py-3 px-4 text-green-400">Completed</td>
                        <td class="py-3 px-4">15/08/2025</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-400 hover:underline">View Details</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-4">₪2,500</td>
                        <td class="py-3 px-4">PayPal</td>
                        <td class="py-3 px-4 text-yellow-400">Pending</td>
                        <td class="py-3 px-4">18/08/2025</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-400 hover:underline">View Details</button>
                        </td>
                    </tr>
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-4">₪1,000</td>
                        <td class="py-3 px-4">Mobile Money</td>
                        <td class="py-3 px-4 text-red-400">Failed</td>
                        <td class="py-3 px-4">10/08/2025</td>
                        <td class="py-3 px-4">
                            <button class="text-blue-400 hover:underline">Retry</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</main>
@endsection
