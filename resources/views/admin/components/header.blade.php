<header class="fixed top-0 left-0 right-0 z-40 bg-white shadow">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
    <div class="flex items-center space-x-3">
      <button id="sidebarToggle" class="md:hidden inline-flex items-center justify-center w-10 h-10 rounded hover:bg-gray-100" aria-label="Open sidebar">
        <i class="fa-solid fa-bars text-lg"></i>
      </button>
      <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-2">
        <i class="fa-solid fa-crown text-yellow-500 text-xl"></i>
        <span class="font-bold text-lg">Admin</span>
      </a>
    </div>
    <div class="flex items-center space-x-4">
      <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::user()->name ?? 'Admin' }}</span>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="px-3 py-1.5 bg-gray-800 text-white rounded hover:bg-gray-700 text-sm">
          Logout
        </button>
      </form>
    </div>
  </div>
</header>

