@extends('user.layouts.app')

@section('title', 'Wallet | Stream2Cash')

@section('content')
<!-- Main Content Area -->
<main class="flex-grow">
    <!-- Wallet Header -->
    <header class="p-6 pt-0">
        <h1 class="text-2xl font-bold mb-1">Wallet</h1>
        <p class="text-sm text-gray-400">Manage your earnings and withdrawals</p>
    </header>
    <div class="flex flex-col gap-2 bg-[#010E5C] rounded-lg lg:p-4 p-2">
    <!-- Wallet Balance Cards -->
    <section class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-2 gap-4 mb-6">
        <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <div class="text-sm text-gray-400">Available Balance</div>
                <div class="text-3xl font-semibold mt-1">₦{{ number_format($wallet_data['balance']) }}</div>
            </div>
            <div class="bg-green-700 p-4 rounded-full text-white text-xl">
                <i class="fa-solid fa-wallet"></i>
            </div>
        </div>
        <div class="space-y-2">
        <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <div class="text-sm text-gray-400">Pending Balance</div>
                <div class="text-3xl font-semibold mt-1">₦{{ number_format($wallet_data['pending']) }}</div>
            </div>
            <div class="bg-yellow-700 p-4 rounded-full text-white text-xl">
                <i class="fa-solid fa-clock"></i>
            </div>
        </div>
        <div class="bg-white p-6 rounded-xl flex items-center justify-between shadow-md">
            <div>
                <div class="text-sm text-gray-400">Total Earned</div>
                <div class="text-3xl font-semibold mt-1">₦{{ number_format($wallet_data['total_earned']) }}</div>
            </div>
            <div class="bg-blue-700 p-4 rounded-full text-white text-xl">
                <i class="fa-solid fa-chart-line"></i>
            </div>
        </div>
    </div>
    </section>

    <!-- Quick Actions -->
    <section class="p-6 rounded-xl mb-6">
        <h2 class="text-xl text-white font-semibold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <a href="{{ route('user.withdrawal') }}" class="bg-blue-700 hover:bg-blue-600 text-white p-4 rounded-lg flex items-center justify-between transition-colors">
                <div>
                    <div class="font-semibold">Withdraw Funds</div>
                    <div class="text-sm text-gray-300">Request a withdrawal</div>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{ route('user.tasks') }}" class="bg-green-700 hover:bg-green-600 text-white p-4 rounded-lg flex items-center justify-between transition-colors">
                <div>
                    <div class="font-semibold">Earn More</div>
                    <div class="text-sm text-gray-300">Complete tasks to earn</div>
                </div>
                <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </section>

    <!-- Transaction History -->
    <section class="bg-blue-900 text-white p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Transaction History</h2>
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
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-4 text-green-400">Earning</td>
                        <td class="py-3 px-4">Video watch task completed</td>
                        <td class="py-3 px-4 text-green-400">+₦100</td>
                        <td class="py-3 px-4 text-green-400">Completed</td>
                        <td class="py-3 px-4">19/08/2025</td>
                    </tr>
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-4 text-red-400">Withdrawal</td>
                        <td class="py-3 px-4">Bank transfer to account</td>
                        <td class="py-3 px-4 text-red-400">-₦5,000</td>
                        <td class="py-3 px-4 text-green-400">Completed</td>
                        <td class="py-3 px-4">15/08/2025</td>
                    </tr>
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-4 text-green-400">Earning</td>
                        <td class="py-3 px-4">Survey task completed</td>
                        <td class="py-3 px-4 text-green-400">+₦75</td>
                        <td class="py-3 px-4 text-green-400">Completed</td>
                        <td class="py-3 px-4">18/08/2025</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
    </div>
</main>
@endsection
