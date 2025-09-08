<!-- Settings Page -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-20">
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-4xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Platform Settings</h1>
          <p class="text-gray-600">Configure platform-wide settings and preferences</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
        </a>
      </div>

      <!-- Settings Form -->
      <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-8">
        @csrf
        @method('PATCH')

        <!-- General Settings -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">General Settings</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Site Name *</label>
              <input type="text" id="site_name" name="site_name" value="{{ old('site_name', 'Stream2Cash') }}"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('site_name') border-red-500 @enderror"
                     required>
              @error('site_name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="admin_email" class="block text-sm font-medium text-gray-700 mb-2">Admin Email *</label>
              <input type="email" id="admin_email" name="admin_email" value="{{ old('admin_email', 'admin@example.com') }}"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('admin_email') border-red-500 @enderror"
                     required>
              @error('admin_email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Withdrawal Settings -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Withdrawal Settings</h3>
          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label for="min_withdrawal" class="block text-sm font-medium text-gray-700 mb-2">Minimum Withdrawal (₪) *</label>
              <input type="number" id="min_withdrawal" name="min_withdrawal" value="{{ old('min_withdrawal', 50) }}"
                     step="0.01" min="1"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('min_withdrawal') border-red-500 @enderror"
                     required>
              @error('min_withdrawal')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="max_withdrawal" class="block text-sm font-medium text-gray-700 mb-2">Maximum Withdrawal (₪) *</label>
              <input type="number" id="max_withdrawal" name="max_withdrawal" value="{{ old('max_withdrawal', 10000) }}"
                     step="0.01" min="1"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('max_withdrawal') border-red-500 @enderror"
                     required>
              @error('max_withdrawal')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="withdrawal_fee" class="block text-sm font-medium text-gray-700 mb-2">Withdrawal Fee (₪) *</label>
              <input type="number" id="withdrawal_fee" name="withdrawal_fee" value="{{ old('withdrawal_fee', 5) }}"
                     step="0.01" min="0"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('withdrawal_fee') border-red-500 @enderror"
                     required>
              @error('withdrawal_fee')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Task Settings -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Task Settings</h3>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="default_task_reward" class="block text-sm font-medium text-gray-700 mb-2">Default Task Reward (₪)</label>
              <input type="number" id="default_task_reward" name="default_task_reward" value="{{ old('default_task_reward', 0.50) }}"
                     step="0.01" min="0.01"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>

            <div>
              <label for="max_task_duration" class="block text-sm font-medium text-gray-700 mb-2">Maximum Task Duration (seconds)</label>
              <input type="number" id="max_task_duration" name="max_task_duration" value="{{ old('max_task_duration', 300) }}"
                     min="1"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            </div>
          </div>
        </div>

        <!-- Security Settings -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Security Settings</h3>
          <div class="space-y-4">
            <div class="flex items-center">
              <input type="checkbox" id="require_email_verification" name="require_email_verification" value="1"
                     {{ old('require_email_verification', true) ? 'checked' : '' }}
                     class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="require_email_verification" class="ml-2 block text-sm text-gray-900">
                Require email verification for new users
              </label>
            </div>

            <div class="flex items-center">
              <input type="checkbox" id="enable_two_factor" name="enable_two_factor" value="1"
                     {{ old('enable_two_factor', false) ? 'checked' : '' }}
                     class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="enable_two_factor" class="ml-2 block text-sm text-gray-900">
                Enable two-factor authentication for admins
              </label>
            </div>

            <div class="flex items-center">
              <input type="checkbox" id="log_admin_actions" name="log_admin_actions" value="1"
                     {{ old('log_admin_actions', true) ? 'checked' : '' }}
                     class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
              <label for="log_admin_actions" class="ml-2 block text-sm text-gray-900">
                Log all admin actions
              </label>
            </div>
          </div>
        </div>

        <!-- Save Button -->
        <div class="flex justify-end">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg transition-colors">
            <i class="fa-solid fa-save mr-2"></i>Save Settings
          </button>
        </div>
      </form>

    </div>
  </section>
</div>

@endsection
