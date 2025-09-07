@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- 404 Error Page -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8 text-center">
      <div class="mb-6">
        <i class="fa-solid fa-search text-6xl text-blue-500 mb-4"></i>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">404</h1>
        <h2 class="text-xl font-semibold text-gray-600 mb-4">Page Not Found</h2>
        <p class="text-gray-600 mb-6">
          The page you're looking for doesn't exist or has been moved.
        </p>
      </div>

      <div class="space-y-4">
        <a href="{{ route('home') }}" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 block">
          <i class="fa-solid fa-home mr-2"></i>
          Go Home
        </a>

        <button onclick="history.back()" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95">
          <i class="fa-solid fa-arrow-left mr-2"></i>
          Go Back
        </button>
      </div>

      <div class="mt-6 text-sm text-gray-500">
        <p>You might want to check:</p>
        <ul class="text-left mt-2 space-y-1">
          <li>• The URL is spelled correctly</li>
          <li>• The page hasn't been moved</li>
          <li>• You have the right permissions</li>
        </ul>
      </div>
    </div>
  </section>

  </div>
@include('components.footer')
</body>
</html>
