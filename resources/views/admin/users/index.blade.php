<!-- User Management Index -->
@extends('admin.layouts.app')

@section('content')

<div class="pt-8">
  <section class="flex justify-center items-center py-8 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-6xl p-8">

      <!-- Header -->
      <div class="flex justify-between items-center mb-8">
        <div>
          <h1 class="text-3xl font-bold text-gray-800 mb-2">User Management</h1>
          <p class="text-gray-600">Manage user accounts and permissions</p>
        </div>
        <div class="flex gap-3">
          <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-user-plus mr-2"></i>Create User
          </a>
          <a href="{{ route('admin.dashboard') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-arrow-left mr-2"></i>Back to Dashboard
          </a>
        </div>
      </div>

      <!-- Search and Filters -->
      <div class="bg-gray-50 p-4 rounded-xl mb-6">
        <form method="GET" class="flex flex-wrap gap-4">
          <div class="flex-1 min-w-64">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users by name or email..."
                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
          </div>
          <select name="role" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">All Roles</option>
            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Users</option>
            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admins</option>
          </select>
          <select name="status" class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
          <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
            <i class="fa-solid fa-search mr-2"></i>Search
          </button>
        </form>
      </div>

      <!-- Users Table -->
      <div class="overflow-x-auto">
        <table class="w-full bg-white border border-gray-200 rounded-lg">
          <thead class="bg-gray-50">
            <tr>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Balance</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
              <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-gray-200">
            @forelse($users as $user)
              <tr class="hover:bg-gray-50">
                <td class="px-6 py-4 whitespace-nowrap">
                  <div class="flex items-center">
                    <div class="flex-shrink-0 h-10 w-10">
                      <div class="h-10 w-10 rounded-full bg-blue-500 flex items-center justify-center text-white font-semibold">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                      </div>
                    </div>
                    <div class="ml-4">
                      <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                      <div class="text-sm text-gray-500">{{ $user->email }}</div>
                    </div>
                  </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                    {{ ucfirst($user->role) }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                    ₦ {{ number_format($user->balance, 2) }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                  <span class="px-2 py-1 text-xs font-semibold rounded-full
                    {{ $user->status === 'active' ? 'bg-green-100 text-green-800' :
                       ($user->status === 'suspended' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ ucfirst($user->status ?? 'active') }}
                  </span>
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                  {{ $user->created_at->format('M d, Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                  <div class="flex space-x-2">
                    <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:text-blue-900" title="View Details">
                      <i class="fa-solid fa-eye"></i>
                    </a>
                    <a href="{{ route('admin.users.ip-records', $user) }}" class="text-green-600 hover:text-green-900" title="View IP Records">
                      <i class="fa-solid fa-globe"></i>
                    </a>
                    @if($user->role === 'user' && $user->status === 'active')
                      <form method="POST" action="{{ route('admin.impersonate', $user) }}" class="inline">
                        @csrf
                        <button type="submit" class="text-purple-600 hover:text-purple-900" title="Impersonate User"
                                onclick="return confirm('Are you sure you want to impersonate this user?')">
                          <i class="fa-solid fa-user-secret"></i>
                        </button>
                      </form>
                    @endif
                    <form method="POST" action="{{ route('admin.users.toggle-status', $user) }}" class="inline">
                      @csrf
                      @method('PATCH')
                      <button type="submit" class="text-yellow-600 hover:text-yellow-900" title="Toggle Status">
                        <i class="fa-solid fa-toggle-{{ $user->status === 'active' ? 'on' : 'off' }}"></i>
                      </button>
                    </form>
                    @if($user->id !== Auth::id())
                      <form method="POST" action="{{ route('admin.users.delete', $user) }}" class="inline"
                            onsubmit="return confirm('Are you sure you want to delete this user?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-900" title="Delete User">
                          <i class="fa-solid fa-trash"></i>
                        </button>
                      </form>
                    @endif
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No users found</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>

      <!-- Pagination -->
      @if($users->hasPages())
        <div class="mt-6">
          {{ $users->appends(request()->query())->links() }}
        </div>
      @endif

    </div>
  </section>
</div>

@include('admin.components.footer')
@endsection
