@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Hero Section -->
  <section class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 md:gap-8 px-4 md:px-12 py-8 md:py-12 items-center">
    <div data-aos="fade-right">
      <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight animate-fadeIn">Earn Free Gift Cards</h1>
      <p class="mt-4 text-base md:text-lg">Fast, Easy & Reliable Online Rewards</p>
      <div class="flex flex-col sm:flex-row gap-3 md:gap-4 mt-6">
        <a href="{{ route('login') }}" class="bg-white text-[#0A1C64] px-4 md:px-6 py-2 rounded-md font-semibold text-center">Sign In</a>
        <a href="{{ route('register')}}" class="bg-yellow-400 text-black px-4 md:px-6 py-2 rounded-md font-semibold text-center">Register</a>
      </div>
      <ul class="mt-6 space-y-2 text-base md:text-lg">
        <li>✔ Complete Offers, Surveys & Tasks</li>
        <li>✔ Free PayPal Cash and Gift Cards</li>
        <li>✔ Competitive Payout Rates</li>
        <li>✔ 1,000+ Instant Rewards</li>
      </ul>
    </div>
    <div class="flex justify-center" data-aos="fade-left">
      <img src="{{asset('images/hero-1-img.png')}}" alt="Hero Image" class="w-full md:w-2/3 rounded-lg shadow-lg" loading="lazy">
    </div>
  </section>

  <!-- User Testimonies -->
  <section class="bg-[#081750]">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 md:gap-8 px-4 md:px-12 py-8 md:py-12 items-center">
      <div data-aos="fade-up">
        <h2 class="text-xl md:text-2xl font-bold mb-4 md:mb-6">User Testimonies</h2>
        <div class="bg-white text-black rounded-lg p-4 md:p-6 shadow-md max-w-md">
          <div class="flex items-center gap-3 md:gap-4">
            <img src="{{asset('images/hero-3-img.png')}}" alt="User" class="rounded-full w-12 h-12 md:w-16 md:h-16" loading="lazy">
            <div>
              <h3 class="font-semibold text-sm md:text-base">Emmanuel Chukwu</h3>
              <p class="text-xs md:text-sm mt-1">Wonderful platform with easy to do task to make money, i got paid instantly</p>
              <p class="text-yellow-400 mt-2 text-sm">★★★★★</p>
              <p class="text-xs text-gray-600">Student</p>
            </div>
          </div>
        </div>
      </div>
      <div class="flex justify-center" data-aos="zoom-in">
        <img src="{{asset('images/hero-2-img.png')}}" alt="Hero Image" class="w-full md:w-1/2 rounded-lg shadow-lg" loading="lazy">
      </div>
    </div>
  </section>

  <!-- How it works -->
  <section class="max-w-7xl mx-auto px-4 md:px-12 py-8 md:py-12">
    <h2 class="text-xl md:text-2xl font-bold mb-6 md:mb-8 text-center" data-aos="fade-up">How it works</h2>
    <div class="flex justify-center" data-aos="zoom-in">
      <img src="{{asset('images/hero-4-img.png')}}" alt="Hero Image" class="w-full md:w-auto rounded-lg shadow-lg" loading="lazy">
    </div>
    <div class="flex flex-col sm:flex-row justify-center gap-3 md:gap-4 mt-6 md:mt-8" data-aos="fade-up">
      <a href="#" class="bg-white text-[#0A1C64] px-4 md:px-6 py-2 rounded-md font-semibold text-center">Sign In</a>
      <a href="#" class="bg-yellow-400 text-black px-4 md:px-6 py-2 rounded-md font-semibold text-center">Register</a>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="bg-[#162996] px-4 md:px-12">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4 md:gap-6 px-4 md:px-6 py-8 md:py-12">
      <div data-aos="fade-right">
        <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-4 animate-pulse">Subscribe to our newsletter</h3>
        <p class="text-sm md:text-base">Wonderful platform with easy to do task to make money, i got paid instantly</p>
      </div>
      <div class="flex w-full md:w-auto" data-aos="fade-left">
        <input type="email" placeholder="Enter Your Email Address" class="w-full md:w-80 px-4 py-2 rounded-l-md text-black" />
        <button class="bg-yellow-400 text-black px-4 md:px-6 rounded-r-md font-semibold">Join</button>
      </div>
    </div>
  </section>



  @include('components.footer')
    </div>
