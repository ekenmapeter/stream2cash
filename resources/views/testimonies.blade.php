@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Hero Section -->
  <section class="text-center py-16 px-6 max-w-3xl mx-auto" data-aos="fade-up">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold mb-6">What Our Users Say</h1>
    <p class="text-lg text-gray-300">
        StreamAdolla has transformed the way people earn online.
      Here's what some of our amazing users have to say.
    </p>
  </section>

  <!-- Testimonies Section -->
  <section class="max-w-6xl mx-auto px-4 md:px-6 py-12 grid md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-10">

    <!-- Testimony 1 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="100">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://i.pravatar.cc/80?img=1" alt="User" class="w-12 h-12 rounded-full">
        <div>
          <h4 class="font-bold">Jane Doe</h4>
          <p class="text-sm text-gray-500">Nigeria</p>
        </div>
      </div>
      <div class="flex text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>
      <p class="text-gray-700">
        "I love StreamAdolla! The tasks are simple, and I got paid instantly after completing my first one."
      </p>
    </div>

    <!-- Testimony 2 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="200">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://i.pravatar.cc/80?img=2" alt="User" class="w-12 h-12 rounded-full">
        <div>
          <h4 class="font-bold">Michael Smith</h4>
          <p class="text-sm text-gray-500">Kenya</p>
        </div>
      </div>
      <div class="flex text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>
      <p class="text-gray-700">
        "A wonderful platform. I was able to withdraw my earnings with no hassle. Highly recommended!"
      </p>
    </div>

    <!-- Testimony 3 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="300">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://i.pravatar.cc/80?img=3" alt="User" class="w-12 h-12 rounded-full">
        <div>
          <h4 class="font-bold">Amina Yusuf</h4>
          <p class="text-sm text-gray-500">Ghana</p>
        </div>
      </div>
      <div class="flex text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>
      <p class="text-gray-700">
        "I didn't believe it at first, but after completing a few tasks, I started earning consistently. Great job StreamAdolla!"
      </p>
    </div>

    <!-- Testimony 4 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="400">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://i.pravatar.cc/80?img=4" alt="User" class="w-12 h-12 rounded-full">
        <div>
          <h4 class="font-bold">Chinedu Okeke</h4>
          <p class="text-sm text-gray-500">Nigeria</p>
        </div>
      </div>
      <div class="flex text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>
      <p class="text-gray-700">
        "The best earning platform I've tried. Tasks are easy, and support is always available."
      </p>
    </div>

    <!-- Testimony 5 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="500">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://i.pravatar.cc/80?img=5" alt="User" class="w-12 h-12 rounded-full">
        <div>
          <h4 class="font-bold">Fatou Diallo</h4>
          <p class="text-sm text-gray-500">Senegal</p>
        </div>
      </div>
      <div class="flex text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>
      <p class="text-gray-700">
        "I use StreamAdolla daily. It's reliable, fast, and truly rewarding. I encourage everyone to join."
      </p>
    </div>

    <!-- Testimony 6 -->
    <div class="bg-white text-black rounded-xl shadow-lg p-6" data-aos="fade-up" data-aos-delay="600">
      <div class="flex items-center gap-4 mb-4">
        <img src="https://i.pravatar.cc/80?img=6" alt="User" class="w-12 h-12 rounded-full">
        <div>
          <h4 class="font-bold">David Johnson</h4>
          <p class="text-sm text-gray-500">South Africa</p>
        </div>
      </div>
      <div class="flex text-yellow-400 mb-2">
        <span>★★★★★</span>
      </div>
      <p class="text-gray-700">
        "StreamAdolla has been a game-changer for me. I can earn money while doing simple tasks. Amazing platform!"
      </p>
    </div>

  </section>

  <!-- Call to Action -->
  <section class="text-center py-16 px-6" data-aos="zoom-in">
    <h2 class="text-2xl md:text-3xl lg:text-4xl font-bold mb-6">Join Our Happy Community</h2>
    <p class="text-lg text-gray-300 mb-8 max-w-2xl mx-auto">
      Thousands are already earning with StreamAdolla.
      Don't miss out on the opportunity to get rewarded for simple tasks.
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
