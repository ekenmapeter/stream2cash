   <!-- Font Awesome -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<aside id="adminSidebar" class="fixed top-16 left-0 bottom-0 w-64 bg-white border-r z-30 transform -translate-x-full md:translate-x-0 transition-transform duration-200 ease-out">
  <nav class="p-4 space-y-1">
    <a href="{{ route('admin.dashboard') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.dashboard') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-gauge mr-3"></i>
      <span>Dashboard</span>
    </a>
    <a href="{{ route('admin.users') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.users*') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-users mr-3"></i>
      <span>Users</span>
    </a>
    <a href="{{ route('admin.tasks') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.tasks*') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-tasks mr-3"></i>
      <span>Tasks</span>
    </a>
    <a href="{{ route('admin.withdrawals') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.withdrawals*') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-money-bill-transfer mr-3"></i>
      <span>Withdrawals</span>
    </a>
    <a href="{{ route('admin.analytics') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.analytics*') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-chart-line mr-3"></i>
      <span>Analytics</span>
    </a>
    <a href="{{ route('admin.reports') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.reports') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-file-export mr-3"></i>
      <span>Reports</span>
    </a>
    <a href="{{ route('admin.settings') }}" class="flex items-center px-3 py-2 rounded hover:bg-gray-100 {{ request()->routeIs('admin.settings') ? 'bg-gray-100 font-semibold' : '' }}">
      <i class="fa-solid fa-cog mr-3"></i>
      <span>Settings</span>
    </a>
  </nav>
</aside>

<script>
  (function(){
    const toggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('adminSidebar');
    if (!toggle || !sidebar) return;
    toggle.addEventListener('click', () => {
      const isHidden = sidebar.classList.contains('-translate-x-full');
      sidebar.classList.toggle('-translate-x-full', !isHidden);
    });
    // Close on route change-like clicks
    sidebar.querySelectorAll('a').forEach(a => a.addEventListener('click', () => {
      if (window.innerWidth < 768) sidebar.classList.add('-translate-x-full');
    }));
  })();
</script>

