@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Register Form -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-center mb-2">Register</h2>
      <p class="text-center text-sm mb-6">Please, enter your personal details</p>

      <!-- Session Status -->
      @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
          {{ session('status') }}
        </div>
      @endif

      <!-- Google Signup -->
      <button class="w-full flex items-center justify-center bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold mb-6 transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
        <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Google" class="w-5 h-5 mr-2">
        Continue with Google
      </button>

      <div class="flex items-center justify-center mb-6">
        <span class="border-b w-1/3"></span>
        <span class="px-2 text-gray-400 text-xs">OR</span>
        <span class="border-b w-1/3"></span>
      </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name Input -->
        <div class="mb-4">
          <label class="flex items-center border rounded-md px-3 py-2 @error('name') border-red-500 @enderror">
            <span class="fa-solid fa-user text-gray-500 mr-2"></span>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name" class="w-full outline-none" required autofocus autocomplete="name" />
          </label>
          @error('name')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Email Input -->
        <div class="mb-4">
          <label class="flex items-center border rounded-md px-3 py-2 @error('email') border-red-500 @enderror">
            <span class="fa-solid fa-envelope text-gray-500 mr-2"></span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="Email" class="w-full outline-none" required autocomplete="username" />
          </label>
          @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="mb-4">
          <label class="flex items-center border rounded-md px-3 py-2 @error('password') border-red-500 @enderror">
            <span class="fa-solid fa-lock text-gray-500 mr-2"></span>
            <input type="password" name="password" placeholder="Password" class="w-full outline-none" required autocomplete="new-password" />
          </label>
          @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Confirm Password Input -->
        <div class="mb-6">
          <label class="flex items-center border rounded-md px-3 py-2 @error('password_confirmation') border-red-500 @enderror">
            <span class="fa-solid fa-lock text-gray-500 mr-2"></span>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="w-full outline-none" required autocomplete="new-password" />
          </label>
          @error('password_confirmation')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Register Button -->
        <button type="submit" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
          Register Now
        </button>
      </form>

      <!-- Already have account -->
      <p class="text-center text-sm mt-6">
        Already a user? <a href="{{ route('login') }}" class="font-semibold hover:underline">Login</a>
      </p>
    </div>
  </section>

        </div>
@include('components.footer')
</body>
</html>
