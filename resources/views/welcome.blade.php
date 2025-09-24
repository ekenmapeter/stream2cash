@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Hero Section -->
  <section class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 md:gap-12 px-2 md:px-12 py-12 md:py-16 items-center">
    <!-- Left Content -->
    <div data-aos="fade-right">
      <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold leading-tight animate-fadeIn">
        Get Paid Watching Videos 🎬
      </h1>
      <p class="mt-4 text-base md:text-lg text-white">
        StreamAdolla makes it fun & rewarding — watch videos, earn real cash, and redeem gift cards instantly.
      </p>

      <div class="flex flex-col sm:flex-row gap-3 md:gap-4 mt-6">
        <a href="{{ route('login') }}"
           class="bg-white text-[#0A1C64] px-5 md:px-7 py-3 rounded-lg font-semibold text-center shadow-md hover:shadow-lg transition">
          Sign In
        </a>
        <a href="{{ route('register')}}"
           class="bg-yellow-400 text-black px-5 md:px-7 py-3 rounded-lg font-semibold text-center shadow-md hover:bg-yellow-500 transition">
          Register Free
        </a>
      </div>

      <ul class="mt-6 space-y-2 text-base md:text-lg text-white">
        <li>✔ Watch videos & earn instantly</li>
        <li>✔ Daily new video drops</li>
        <li>✔ Trusted by thousands worldwide</li>
      </ul>
    </div>

    <!-- Right Image -->
    <div class="flex justify-center" data-aos="fade-left">
      <img src="{{asset('images/hero-1-img.png')}}"
           alt="StreamAdolla Rewards"
           class="w-full md:w-5/6 lg:w-[90%] rounded-2xl shadow-xl"
           loading="lazy">
    </div>
  </section>


<!-- User Testimonies -->
<section class="bg-[#162996]">
    <div class="max-w-7xl mx-auto grid md:grid-cols-2 gap-6 md:gap-12 px-4 md:px-12 py-2 md:py-16 items-end">

      <!-- Testimonies Swiper -->
      <div data-aos="fade-up">
        <h2 class="text-xl md:text-2xl font-bold mb-6 text-white">User Testimonies</h2>

        <!-- Swiper Container -->
        <div class="swiper mySwiper max-w-md">
          <div class="swiper-wrapper">

            <!-- Testimony 1 -->
            <div class="swiper-slide bg-white text-black rounded-lg p-4 md:p-6 shadow-md">
              <div class="flex items-center gap-3 md:gap-4">
                <img src="{{asset('images/hero-3-img.png')}}" alt="User" class="rounded-full w-12 h-12 md:w-16 md:h-16" loading="lazy">
                <div>
                  <h3 class="font-semibold text-sm md:text-base">Emmanuel Chukwu</h3>
                  <p class="text-xs md:text-sm mt-1">Wonderful platform with easy tasks to make money. I got paid instantly!</p>
                  <p class="text-yellow-400 mt-2 text-sm">★★★★★</p>
                  <p class="text-xs text-gray-600">Student</p>
                </div>
              </div>
            </div>

            <!-- Testimony 2 -->
            <div class="swiper-slide bg-white text-black rounded-lg p-4 md:p-6 shadow-md">
              <div class="flex items-center gap-3 md:gap-4">
                <img src="{{asset('images/hero-1-img.png')}}" alt="User" class="rounded-full w-12 h-12 md:w-16 md:h-16" loading="lazy">
                <div>
                  <h3 class="font-semibold text-sm md:text-base">Amina Yusuf</h3>
                  <p class="text-xs md:text-sm mt-1">StreamAdolla helped me earn my first PayPal gift card. Super easy!</p>
                  <p class="text-yellow-400 mt-2 text-sm">★★★★★</p>
                  <p class="text-xs text-gray-600">Freelancer</p>
                </div>
              </div>
            </div>

            <!-- Testimony 3 -->
            <div class="swiper-slide bg-white text-black rounded-lg p-4 md:p-6 shadow-md">
              <div class="flex items-center gap-3 md:gap-4">
                <img src="{{asset('images/hero-2-img.png')}}" alt="User" class="rounded-full w-12 h-12 md:w-16 md:h-16" loading="lazy">
                <div>
                  <h3 class="font-semibold text-sm md:text-base">James Okoro</h3>
                  <p class="text-xs md:text-sm mt-1">I watch videos daily and cash out weekly. Totally worth it!</p>
                  <p class="text-yellow-400 mt-2 text-sm">★★★★★</p>
                  <p class="text-xs text-gray-600">Content Creator</p>
                </div>
              </div>
            </div>

          </div>
          <!-- Swiper Pagination -->
          <div class="swiper-pagination mt-4"></div>
        </div>
      </div>

      <!-- Right Image (Bigger) -->
      <div class="flex justify-center items-end" data-aos="zoom-in">
        <img src="{{asset('images/hero-2-img.png')}}"
             alt="Hero Image"
             class="w-full rounded-2xl shadow-xl"
             loading="lazy">
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
