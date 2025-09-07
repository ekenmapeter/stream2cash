@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Login Form -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-center mb-2">Login</h2>
      <p class="text-center text-sm mb-6">Please, enter your username and password</p>

    <!-- Session Status -->
      @if (session('status'))
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
          {{ session('status') }}
        </div>
      @endif

      <!-- Error Messages -->
      @if (session('error'))
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
          {{ session('error') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded-md text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Input -->
        <div class="mb-4">
          <label class="flex items-center border rounded-md px-3 py-2 @error('email') border-red-500 @enderror">
            <span class="fa-solid fa-envelope text-gray-500 mr-2"></span>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="E-Mail" class="w-full outline-none" required autofocus autocomplete="username" />
          </label>
          @error('email')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <!-- Password Input -->
        <div class="mb-2">
          <label class="flex items-center border rounded-md px-3 py-2 @error('password') border-red-500 @enderror">
            <span class="fa-solid fa-lock text-gray-500 mr-2"></span>
            <input type="password" name="password" placeholder="Password" class="w-full outline-none" required autocomplete="current-password" />
          </label>
          @error('password')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
          @enderror
        </div>

        <div class="text-right text-xs mb-6">
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="hover:underline">Forget Password</a>
          @endif
        </div>

        <!-- Remember Me -->
        <div class="mb-4">
          <label class="inline-flex items-center">
            <input type="checkbox" name="remember" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
            <span class="ml-2 text-sm text-gray-600">Remember me</span>
            </label>
        </div>

        <!-- Login Button -->
        <button type="submit" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold mb-4 transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
          Login
        </button>
      </form>

      <div class="flex items-center justify-center mb-4">
        <span class="border-b w-1/3"></span>
        <span class="px-2 text-gray-400 text-xs">OR</span>
        <span class="border-b w-1/3"></span>
      </div>

      <!-- Google Login -->
      <button class="w-full flex items-center justify-center bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
        <img src="https://cdn-icons-png.flaticon.com/512/281/281764.png" alt="Google" class="w-5 h-5 mr-2">
        Login with Google
      </button>

      <!-- Register Link -->
      <p class="text-center text-sm mt-6">
        Don't have an account? <a href="{{ route('register') }}" class="font-semibold hover:underline">Register</a>
      </p>
    </div>
  </section>


        </div>
@include('components.footer')
</body>
</html>
