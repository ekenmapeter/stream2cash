@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- 419 Error Page -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8 text-center">
      <div class="mb-6">
        <i class="fa-solid fa-clock text-6xl text-yellow-500 mb-4"></i>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">Page Expired</h1>
        <p class="text-gray-600 mb-6">
          Your session has expired due to inactivity. Please log in again to continue.
        </p>
      </div>

      <div class="space-y-4">
        <a href="{{ route('login') }}" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 block">
          <i class="fa-solid fa-sign-in-alt mr-2"></i>
          Login Again
        </a>

        <a href="{{ route('home') }}" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 block">
          <i class="fa-solid fa-home mr-2"></i>
          Go Home
        </a>
      </div>

      <div class="mt-6 text-sm text-gray-500">
        <p>This usually happens when:</p>
        <ul class="text-left mt-2 space-y-1">
          <li>• You've been inactive for too long</li>
          <li>• Your browser's cookies were cleared</li>
          <li>• You're using an old form submission</li>
        </ul>
      </div>
    </div>
  </section>

  </div>
@include('components.footer')
</body>
</html>
