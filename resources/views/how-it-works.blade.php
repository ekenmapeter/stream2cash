@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Hero Section -->
  <section class="text-center py-16 px-6 max-w-3xl mx-auto" data-aos="fade-up">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">How Stream2Cash Works</h1>
    <p class="text-lg text-gray-300">
      Getting started with Stream2Cash is simple.
      Follow these six steps to begin your earning journey.
    </p>
  </section>

  <!-- Steps Section -->
  <section class="max-w-6xl mx-auto px-4 md:px-6 py-12 grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">

    <!-- Step 1 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up" data-aos-delay="100">
      <div class="flex items-center mb-4">
        <div class="bg-[#0A1C64] text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3">1</div>
        <h2 class="text-xl font-bold">Sign Up</h2>
      </div>
      <p class="text-gray-700">
        Create your free Stream2Cash account in just a few clicks.
      </p>
    </div>

    <!-- Step 2 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up" data-aos-delay="200">
      <div class="flex items-center mb-4">
        <div class="bg-[#0A1C64] text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3">2</div>
        <h2 class="text-xl font-bold">Complete Profile</h2>
      </div>
      <p class="text-gray-700">
        Fill in your personal details to unlock earning opportunities.
      </p>
    </div>

    <!-- Step 3 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up" data-aos-delay="300">
      <div class="flex items-center mb-4">
        <div class="bg-[#0A1C64] text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3">3</div>
        <h2 class="text-xl font-bold">Apply for Task</h2>
      </div>
      <p class="text-gray-700">
        Browse available tasks and apply for the ones you like.
      </p>
    </div>

    <!-- Step 4 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up" data-aos-delay="400">
      <div class="flex items-center mb-4">
        <div class="bg-[#0A1C64] text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3">4</div>
        <h2 class="text-xl font-bold">Complete Task</h2>
      </div>
      <p class="text-gray-700">
        Finish the assigned tasks accurately and on time.
      </p>
    </div>

    <!-- Step 5 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up" data-aos-delay="500">
      <div class="flex items-center mb-4">
        <div class="bg-[#0A1C64] text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3">5</div>
        <h2 class="text-xl font-bold">Get Paid</h2>
      </div>
      <p class="text-gray-700">
        Earn money instantly for every completed and verified task.
      </p>
    </div>

    <!-- Step 6 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6 md:p-8" data-aos="fade-up" data-aos-delay="600">
      <div class="flex items-center mb-4">
        <div class="bg-[#0A1C64] text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-3">6</div>
        <h2 class="text-xl font-bold">Withdraw Funds</h2>
      </div>
      <p class="text-gray-700">
        Cash out your earnings through your preferred withdrawal method.
      </p>
    </div>

  </section>

  <!-- Call to Action -->
  <section class="text-center py-16 px-6" data-aos="zoom-in">
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6">Start Earning Today!</h2>
    <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
      Sign up now and complete your first task to begin your earning journey with Stream2Cash.
    </p>
    <div class="flex flex-col sm:flex-row gap-4 justify-center">
      <a href="{{ route('register') }}" class="bg-yellow-400 text-black px-6 py-3 rounded-lg font-semibold hover:bg-yellow-500 transition-all duration-200 transform hover:scale-105 active:scale-95">
        Get Started Now
      </a>
      <a href="{{ route('login') }}" class="bg-white text-[#0A1C64] px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition-all duration-200 transform hover:scale-105 active:scale-95">
        Sign In
      </a>
    </div>
  </section>

  </div>
@include('components.footer')
</body>
</html>
