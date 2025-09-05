@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Verify Email Form -->
  <section class="flex justify-center items-center py-20 px-4">
    <div class="bg-white text-black rounded-2xl shadow-lg w-full max-w-md p-8">
      <h2 class="text-3xl font-bold text-center mb-2">Verify Email</h2>
      <p class="text-center text-sm mb-6">Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?</p>

      @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-md text-sm">
          A new verification link has been sent to the email address you provided during registration.
        </div>
      @endif

      <div class="space-y-4">
        <!-- Resend Verification Email -->
        <form method="POST" action="{{ route('verification.send') }}">
          @csrf
          <button type="submit" class="w-full bg-[#0A1C64] hover:bg-[#162996] text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-[#0f1e66]">
            Resend Verification Email
          </button>
        </form>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="w-full bg-gray-500 hover:bg-gray-600 text-white py-3 rounded-md font-semibold transition-all duration-200 transform hover:scale-105 active:scale-95 active:bg-gray-700">
            Log Out
          </button>
        </form>
      </div>

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
