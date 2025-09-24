@include('components.header')
@include('components.navbar')

  <div class="pt-20">

  <!-- Hero Section -->
  <section class="max-w-5xl mx-auto text-center px-4 md:px-6 py-12 md:py-16">
    <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold leading-tight" data-aos="fade-up">
      Turning Screen Time <br />
      Into <span class="bg-yellow-400 text-black px-2 rounded-lg text-2xl md:text-4xl">Earn Time</span>
    </h1>
    <p class="mt-4 md:mt-6 text-base md:text-lg max-w-2xl mx-auto" data-aos="fade-up" data-aos-delay="200">
      At StreamAdolla, we're revolutionizing how people earn money online by rewarding them
      for what they already love to do – watch videos.
    </p>
  </section>

<!-- About Section -->
<section class="max-w-6xl mx-auto px-4 md:px-12 py-8 md:py-12 grid md:grid-cols-1 gap-8 md:gap-12 items-center">
    <div class="space-y-8 md:space-y-12">
      <!-- About Us -->
      <div class="grid md:grid-cols-2 gap-4 md:gap-6 items-center" data-aos="fade-right">
        <div class="flex justify-center">
          <button class="bg-yellow-400 text-black px-4 md:px-6 py-2 rounded-md font-semibold w-full md:w-1/2 text-sm md:text-base">
            About Us:
          </button>
        </div>
        <div>
          <p class="text-base md:text-lg leading-relaxed">
            Welcome to StreamAdolla, the innovative platform that pays you for your viewing time.
            Our mission is to create a fair and transparent ecosystem where users can monetize their
            screen time while advertisers reach engaged audiences.
          </p>
        </div>
      </div>

      <!-- Our Story -->
      <div class="grid md:grid-cols-2 gap-4 md:gap-6 items-center" data-aos="fade-left">
        <div class="flex justify-center">
            <button class="bg-yellow-400 text-black px-4 md:px-6 py-2 rounded-md font-semibold w-full md:w-1/2 text-sm md:text-base">
            Our Story:
          </button>
        </div>
        <div>
          <p class="text-base md:text-lg leading-relaxed">
            What began as a simple idea – "what if people could earn money just by watching videos?" –
            has grown into a thriving community of [X] thousand users worldwide. We noticed that traditional
            advertising models benefited platforms but rarely the viewers. StreamAdolla changes that equation.
          </p>
        </div>
      </div>

      <!-- How It Works -->
      <div class="grid md:grid-cols-2 gap-4 md:gap-6 items-center" data-aos="fade-right">
        <div class="flex justify-center">
          <button class="bg-yellow-400 text-black px-4 md:px-6 py-2 rounded-md font-semibold w-full md:w-1/2 text-sm md:text-base">
            How It Works:
          </button>
        </div>
        <div>
          <ul class="list-decimal list-inside space-y-2 text-base md:text-lg">
            <li>You watch videos from our premium partners</li>
            <li>We track your verified viewing time</li>
            <li>You earn cash for every qualified minute</li>
            <li>Get paid via your preferred method</li>
          </ul>
        </div>
      </div>
    </div>


  </section>


  <!-- Why Choose Section -->
  <section class="max-w-5xl mx-auto px-4 md:px-6 py-12 md:py-16 flex flex-col justify-center items-center">
    <button class="bg-yellow-400 text-black px-4 md:px-6 py-2 rounded-md font-semibold mb-4 md:mb-6 text-sm md:text-base" data-aos="fade-up">Why Choose StreamAdolla</button>

    <div class="p-2 rounded-lg shadow-lg" data-aos="zoom-in">
      <ul class="list-disc list-inside space-y-2 text-base md:text-lg">
        <li><strong>Fair Compensation:</strong> We offer industry-leading rates for video viewing</li>
        <li><strong>Flexible Earning:</strong> Watch whenever you want, as much as you want</li>
        <li><strong>Verified Payments:</strong> Over [$X] million paid out to our community</li>
        <li><strong>Quality Content:</strong> Curated videos from trusted sources</li>
        <li><strong>Privacy Focused:</strong> We respect your data and never sell personal information</li>
      </ul>
    </div>
  </section>


  @include('components.footer')
</body>
</html>
