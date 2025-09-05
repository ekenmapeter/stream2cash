@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Reset Password Form -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-center mb-2">Reset Password</h2>
      <p class="text-center text-sm mb-6">Enter your new password below</p>

      <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Input -->
        <div class="mb-4">
          <label class="flex items-center border rounded-md px-3 py-2 @error('email') border-red-500 @enderror">
            <span class="fa-solid fa-envelope text-gray-500 mr-2"></span>
            <input type="email" name="email" value="{{ old('email', $request->email) }}" placeholder="Email Address" class="w-full outline-none" required autofocus autocomplete="username" />
          </label>
          @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="mb-4">
          <label class="flex items-center border rounded-md px-3 py-2 @error('password') border-red-500 @enderror">
            <span class="fa-solid fa-lock text-gray-500 mr-2"></span>
            <input type="password" name="password" placeholder="New Password" class="w-full outline-none" required autocomplete="new-password" />
          </label>
          @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password Input -->
        <div class="mb-6">
          <label class="flex items-center border rounded-md px-3 py-2 @error('password_confirmation') border-red-500 @enderror">
            <span class="fa-solid fa-lock text-gray-500 mr-2"></span>
            <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="w-full outline-none" required autocomplete="new-password" />
          </label>
          @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Submit Button -->
        <button type="submit" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
          Reset Password
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
