<!-- Footer -->
<footer class="bg-[#162996] text-white px-6 lg:px-12">

    <!-- Logo + About -->
    <div class="block lg:hidden w-full lg:max-w-7xl mx-auto pt-12">
      <h4 class="font-bold text-lg mb-3">Stream2Cash</h4>
      <p class="leading-relaxed max-w-md">
        Wonderful platform with easy-to-do tasks to make money — I got paid instantly.
      </p>
    </div>

    <!-- Links Grid -->
    <div class="w-full lg:max-w-7xl mx-auto py-12 grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 gap-4 lg:gap-12 text-sm" data-aos="fade-up">
 <!-- Logo + About -->
 <div class="hidden lg:block w-full lg:max-w-7xl mx-auto">
    <h4 class="font-bold text-lg mb-3">Stream2Cash</h4>
    <p class="leading-relaxed max-w-md">
      Wonderful platform with easy-to-do tasks to make money — I got paid instantly.
    </p>
  </div>
      <!-- Get Started -->
      <div>
        <h4 class="font-bold text-base lg:text-lg mb-3">Get Started</h4>
        <ul class="space-y-2">
          <li><a href="{{route('login')}}" class="hover:underline">Sign In</a></li>
          <li><a href="{{route('register')}}" class="hover:underline">Register</a></li>
          <li><a href="{{ route('how-it-works')}}" class="hover:underline">How it works</a></li>
        </ul>
      </div>

      <!-- Company -->
      <div>
        <h4 class="font-bold text-base lg:text-lg mb-3">Company</h4>
        <ul class="space-y-2">
        <li><a href="{{ route('about') }}" class="hover:underline">About Us</a></li>
          <li><a href="{{ route('contact') }}" class="hover:underline">Contact Us</a></li>
          <li><a href="{{ route('testimonies') }}" class="hover:underline">Testimonies</a></li>
        </ul>
      </div>

      <!-- Get in touch -->
      <div>
        <h4 class="font-bold text-base lg:text-lg mb-3">Get in Touch</h4>
        <ul class="space-y-2">
          <li><a href="#" class="hover:underline">Terms and Conditions</a></li>
          <li><a href="#" class="hover:underline">Privacy Policy</a></li>
        </ul>
      </div>
    </div>

    <!-- Bottom Bar -->
    <div class="text-center py-4 text-xs text-gray-200">
      Copyright © 2025 <span class="font-semibold">Stream2Cash</span>. All rights reserved.
    </div>
  </footer>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1000,
      once: true,
      mirror: true
    });
  </script>


</body>
</html>

