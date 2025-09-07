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

    <!-- Profile Information -->
    <section class="bg-gray-800 p-6 rounded-xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Personal Information</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Full Name</label>
                <input type="text" value="{{ $user->name }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Email Address</label>
                <input type="email" value="{{ $user->email }}" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Phone Number</label>
                <input type="tel" placeholder="Not provided" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white" readonly>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Country</label>
                <input type="text" placeholder="Not provided" class="w-full bg-gray-700 border border-gray-600 rounded-lg px-3 py-2 text-white" readonly>
            </div>
        </div>
        <div class="mt-6">
            <button class="bg-blue-700 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors">
                Edit Profile
            </button>
        </div>
    </section>

    <!-- Account Statistics -->
    <section class="bg-gray-800 p-6 rounded-xl shadow-lg mb-6">
        <h2 class="text-xl font-semibold mb-4">Account Statistics</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-3xl font-bold text-blue-400">4</div>
                <div class="text-sm text-gray-400">Tasks Completed</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-green-400">₪15,000</div>
                <div class="text-sm text-gray-400">Total Earned</div>
            </div>
            <div class="text-center">
                <div class="text-3xl font-bold text-yellow-400">15</div>
                <div class="text-sm text-gray-400">Withdrawals</div>
            </div>
        </div>
    </section>

    <!-- Security Settings -->
    <section class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-xl font-semibold mb-4">Security Settings</h2>
        <div class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div>
                    <div class="font-medium">Change Password</div>
                    <div class="text-sm text-gray-400">Update your account password</div>
                </div>
                <button class="bg-blue-700 hover:bg-blue-600 text-white py-2 px-4 rounded-lg transition-colors">
                    Change
                </button>
            </div>
            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div>
                    <div class="font-medium">Two-Factor Authentication</div>
                    <div class="text-sm text-gray-400">Add an extra layer of security</div>
                </div>
                <button class="bg-green-700 hover:bg-green-600 text-white py-2 px-4 rounded-lg transition-colors">
                    Enable
                </button>
            </div>
            <div class="flex items-center justify-between p-4 bg-gray-700 rounded-lg">
                <div>
                    <div class="font-medium">Email Verification</div>
                    <div class="text-sm text-gray-400">Your email is verified</div>
                </div>
                <span class="text-green-400">
                    <i class="fa-solid fa-check-circle"></i>
                </span>
            </div>
        </div>
    </section>
</main>
@endsection
