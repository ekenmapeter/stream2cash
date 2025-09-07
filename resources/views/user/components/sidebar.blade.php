   <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

   <!-- Mobile Menu Button -->
    <button id="mobile-menu-btn" class="lg:hidden fixed top-4 right-4 z-50 p-2 text-black bg-blue-800 rounded-md">
        <i class="fa-solid fa-bars"></i>
    </button>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out bg-[#F4F4F4] w-64 flex flex-col shadow-lg z-40">
        <div class="p-6 text-2xl font-bold text-black text-center">
            Stream2Cash
        </div>

        <!-- Navigation Links -->
        <nav class="flex-grow p-4 space-y-2 text-black font-bold">
            @if(Auth::user()->role === 'admin')
                <!-- Admin Navigation -->
                <a href="{{ route('admin.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-crown w-5"></i>
                    <span>Admin Dashboard</span>
                </a>
                <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-home w-5"></i>
                    <span>User Dashboard</span>
                </a>
            @else
                <!-- User Navigation -->
                <a href="{{ route('user.dashboard') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('user.dashboard') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-home w-5"></i>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('user.wallet') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('user.wallet') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-wallet w-5"></i>
                    <span>Wallet</span>
                </a>
                <a href="{{ route('user.tasks') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('user.tasks') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-list-check w-5"></i>
                    <span>Tasks</span>
                </a>
                <a href="{{ route('user.profile') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('user.profile') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-user-circle w-5"></i>
                    <span>Profile</span>
                </a>
                <a href="{{ route('user.withdrawal') }}" class="flex items-center space-x-3 p-3 rounded-lg hover:bg-gray-700 transition-colors duration-200 {{ request()->routeIs('user.withdrawal') ? 'bg-blue-700 text-white' : '' }}">
                    <i class="fa-solid fa-money-bill-transfer w-5"></i>
                    <span>Withdrawal</span>
                </a>
            @endif
        </nav>

        <!-- User and Logout -->
        <div class="p-4 border-t border-b border-gray-700">
            <div class="mb-4">
                <div class="text-sm text-black">{{ Auth::user()->name ?? 'username' }}</div>
                <div class="text-xs text-black">Last Login: {{ Auth::user()->last_login_at ? Auth::user()->last_login_at->diffForHumans() : '45 minutes ago' }}</div>
            </div>
        </div>
        <div class="p-4">

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center space-x-3 p-3 rounded-lg text-red-600 hover:bg-gray-700 transition-colors duration-200 w-full">
                    <i class="fa-solid fa-right-from-bracket w-5"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>
