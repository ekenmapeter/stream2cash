@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- 500 Error Page -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8 text-center">
      <div class="mb-6">
        <i class="fa-solid fa-exclamation-triangle text-6xl text-red-500 mb-4"></i>
        <h1 class="text-4xl font-bold text-gray-800 mb-2">500</h1>
        <h2 class="text-xl font-semibold text-gray-600 mb-4">Server Error</h2>
        <p class="text-gray-600 mb-6">
          Something went wrong on our end. We're working to fix this issue.
        </p>
      </div>

      <div class="space-y-4">
        <a href="{{ route('home') }}" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 block">
          <i class="fa-solid fa-home mr-2"></i>
          Go Home
        </a>
        
        <button onclick="window.location.reload()" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95">
          <i class="fa-solid fa-refresh mr-2"></i>
          Try Again
        </button>
      </div>

      <div class="mt-6 text-sm text-gray-500">
        <p>If the problem persists, please contact our support team.</p>
      </div>
    </div>
  </section>

  </div>
@include('components.footer')
</body>
</html>
