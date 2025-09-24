  <!-- Navbar -->
  <nav class="bg-[#0A1C64] fixed top-0 left-0 right-0 z-50" data-aos="fade-down">
    <div class="max-w-7xl mx-auto px-6 flex justify-between items-center py-4">
      <div class="text-xl font-bold ">
        <img src="{{ asset('images/logo.png') }}" alt="StreamAdolla" class="rounded-lg w-full">
      </div>

      <!-- Desktop Menu -->
      <ul class="hidden md:flex gap-6 text-sm">
        <li><a href="{{ route('home') }}" class="hover:underline">Home</a></li>
        <li><a href="{{ route('how-it-works') }}" class="hover:underline">How it work</a></li>
        <li><a href="{{ route('testimonies') }}" class="hover:underline">Testimonies</a></li>
        <li><a href="{{ route('about') }}" class="hover:underline">About</a></li>
        <li><a href="{{ route('contact') }}" class="hover:underline">Contact Us</a></li>
      </ul>

      <!-- CTA (Desktop) -->
      <a href="{{ route('register') }}" class="hidden md:inline-block bg-white text-[#0A1C64] px-4 py-2 rounded-md font-semibold">Get started</a>

      <!-- Mobile Hamburger -->
      <button id="mobile-nav-toggle" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-white hover:bg-white/10 focus:outline-none focus:ring-2 focus:ring-white/40" aria-controls="mobile-menu" aria-expanded="false">
        <span class="sr-only">Open main menu</span>
        <!-- Icon: Menu -->
        <svg id="icon-menu" class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
        </svg>
        <!-- Icon: Close -->
        <svg id="icon-close" class="h-6 w-6 hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>

    <!-- Mobile Menu -->
    <div id="mobile-menu" class="md:hidden hidden border-t border-white/10 bg-[#0A1C64]">
      <div class="px-6 py-4 space-y-4">
        <a href="{{ route('home') }}" class="block text-white hover:underline">Home</a>
        <a href="{{ route('how-it-works') }}" class="block text-white hover:underline">How it work</a>
        <a href="{{ route('testimonies') }}" class="block text-white hover:underline">Testimonies</a>
        <a href="{{ route('about') }}" class="block text-white hover:underline">About</a>
        <a href="{{ route('contact') }}" class="block text-white hover:underline">Contact Us</a>
        <a href="{{ route('register') }}" class="block bg-white text-[#0A1C64] px-4 py-2 rounded-md font-semibold text-center">Get started</a>
      </div>
    </div>
  </nav>

  <script>
    (function() {
      var toggleButton = document.getElementById('mobile-nav-toggle');
      var mobileMenu = document.getElementById('mobile-menu');
      var iconMenu = document.getElementById('icon-menu');
      var iconClose = document.getElementById('icon-close');
      if (!toggleButton || !mobileMenu) return;
      toggleButton.addEventListener('click', function() {
        var isHidden = mobileMenu.classList.contains('hidden');
        mobileMenu.classList.toggle('hidden');
        toggleButton.setAttribute('aria-expanded', String(isHidden));
        if (iconMenu && iconClose) {
          iconMenu.classList.toggle('hidden');
          iconClose.classList.toggle('hidden');
        }
      });
    })();
  </script>

