@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Confirm Password Form -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-center mb-2">Confirm Password</h2>
      <p class="text-center text-sm mb-6">This is a secure area of the application. Please confirm your password before continuing.</p>

      <form method="POST" action="{{ route('password.confirm') }}">
        @csrf

        <!-- Password Input -->
        <div class="mb-6">
          <label class="flex items-center border rounded-md px-3 py-2 @error('password') border-red-500 @enderror">
            <span class="fa-solid fa-lock text-gray-500 mr-2"></span>
            <input type="password" name="password" placeholder="Password" class="w-full outline-none" required autocomplete="current-password" />
          </label>
          @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
          Confirm
        </button>
      </form>

      <!-- Back to Home -->
      <p class="text-center text-sm mt-6">
        <a href="{{ route('home') }}" class="font-semibold hover:underline">← Back to Home</a>
      </p>
    </div>
  </section>

  </div>
@include('components.footer')
</body>
</html>
