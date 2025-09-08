<!-- Create User View -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-8">
  <section class="flex justify-center items-center py-8 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-2xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">Create New User</h1>
          <p class="text-gray-600">Add a new user to the system</p>
        </div>
        <a href="{{ route('admin.users') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
          <i class="fa-solid fa-arrow-left mr-2"></i>Back to Users
        </a>
      </div>

      <!-- Create User Form -->
      <form method="POST" action="{{ route('admin.users.store') }}" class="space-y-6">
        @csrf

        <!-- Basic Information -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Basic Information</h3>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
              <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Full Name *</label>
              <input type="text" id="name" name="name" value="{{ old('name') }}" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('name') border-red-500 @enderror"
                     placeholder="Enter full name">
              @error('name')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address *</label>
              <input type="email" id="email" name="email" value="{{ old('email') }}" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                     placeholder="Enter email address">
              @error('email')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
            <div>
              <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password *</label>
              <input type="password" id="password" name="password" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror"
                     placeholder="Enter password (min 8 characters)">
              @error('password')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">Confirm Password *</label>
              <input type="password" id="password_confirmation" name="password_confirmation" required
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                     placeholder="Confirm password">
            </div>
          </div>
        </div>

        <!-- Account Settings -->
        <div class="bg-gray-50 p-6 rounded-xl">
          <h3 class="text-lg font-semibold mb-4">Account Settings</h3>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div>
              <label for="role" class="block text-sm font-medium text-gray-700 mb-2">Role *</label>
              <select id="role" name="role" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('role') border-red-500 @enderror">
                <option value="">Select Role</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
              </select>
              @error('role')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
              <select id="status" name="status" required
                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('status') border-red-500 @enderror">
                <option value="">Select Status</option>
                <option value="active" {{ old('status') == 'active' ? 'selected' : '' }}>Active</option>
                <option value="suspended" {{ old('status') == 'suspended' ? 'selected' : '' }}>Suspended</option>
                <option value="blocked" {{ old('status') == 'blocked' ? 'selected' : '' }}>Blocked</option>
              </select>
              @error('status')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>

            <div>
              <label for="balance" class="block text-sm font-medium text-gray-700 mb-2">Initial Balance</label>
              <input type="number" id="balance" name="balance" value="{{ old('balance', 0) }}" min="0" step="0.01"
                     class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('balance') border-red-500 @enderror"
                     placeholder="0.00">
              @error('balance')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
              @enderror
            </div>
          </div>
        </div>

        <!-- Form Actions -->
        <div class="flex gap-4">
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-user-plus mr-2"></i>Create User
          </button>
          <a href="{{ route('admin.users') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-6 py-2 rounded-lg transition-colors">
            Cancel
          </a>
        </div>
      </form>

    </div>
  </section>
</div>

@endsection
