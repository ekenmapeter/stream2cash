@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Forgot Password Form -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-center mb-2">Forgot Password</h2>
      <p class="text-center text-sm mb-6">No problem. Just let us know your email address and we will email you a password reset link.</p>

      <!-- Session Status -->
      @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
          {{ session('status') }}
        </div>
      @endif

      <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Input -->
        <div class="mb-6">
          <label class="flex items-center border rounded-md px-3 py-2 @error('email') border-red-500 @enderror">
            <span class="fa-solid fa-envelope text-gray-500 mr-2"></span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email Address" class="w-full outline-none" required autofocus />
          </label>
          @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold mb-4 transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
          Email Password Reset Link
        </button>
      </form>

      <!-- Back to Login -->
      <p class="text-center text-sm mt-6">
        Remember your password? <a href="{{ route('login') }}" class="font-semibold hover:underline">Login</a>
      </p>
    </div>
  </section>

  </div>
@include('components.footer')
</body>
</html>
