@include('components.header')
@include('components.navbar')

  <div class="pt-20">


  <!-- Contact Us Header -->
  <section class="w-full lg:max-w-5xl mx-auto grid md:grid-cols-2 gap-8 px-4 lg:px-12 py-16 items-center">
    <div data-aos="fade-right">
      <h1 class="text-5xl lg:text-7xl font-bold mb-4">Contact Us</h1>
      <p class="text-lg leading-relaxed mb-6">
        At Stream2Cash, we're revolutionizing how people earn money online by rewarding them
        for what they already love to do - watch videos.
      </p>
      <p class="mb-2 text-1xl">info@stream2cash.com</p>
      <p class="text-1xl">+2349000000000</p>
    </div>
    <div class="flex justify-center" data-aos="fade-left">
      <img src="{{asset('images/contact-1-img.png')}}" alt="Contact Illustration" class="w-full lg:w-2/3">
    </div>
  </section>

  <!-- Support Boxes -->
  <section class="max-w-5xl mx-auto px-4 md:px-12 grid md:grid-cols-2 gap-4 md:gap-8 text-center py-8">
    <div class="rounded-lg p-4 md:p-6" data-aos="fade-up">
      <h3 class="font-bold text-lg md:text-xl mb-3">Customer Support</h3>
      <p class="text-sm leading-relaxed">
        At Stream2Cash, we're revolutionizing how people earn money online
        by rewarding them for what they already love to do - watch videos.
      </p>
    </div>
    <div class="rounded-lg p-4 md:p-6" data-aos="fade-up" data-aos-delay="200">
      <h3 class="font-bold text-lg md:text-xl mb-3">Feedback and Suggestions</h3>
      <p class="text-sm leading-relaxed">
        At Stream2Cash, we're revolutionizing how people earn money online
        by rewarding them for what they already love to do - watch videos.
      </p>
    </div>
  </section>

  <!-- Contact Form -->
  <section class="max-w-3xl mx-auto px-4 md:px-6 py-8 md:py-12">
    <div class="bg-white text-black rounded-xl p-4 md:p-8 shadow-md" data-aos="zoom-in">
      <h2 class="text-xl md:text-2xl font-bold mb-2">Get in Touch</h2>
      <p class="mb-4 md:mb-6 text-sm">You can reach us anytime.</p>
      <form action="#" method="POST" class="space-y-4">
        <div class="grid md:grid-cols-2 gap-4">
          <input type="text" placeholder="First Name" class="w-full border px-4 py-2 rounded-md" />
          <input type="text" placeholder="Last Name" class="w-full border px-4 py-2 rounded-md" />
        </div>
        <input type="email" placeholder="E-Mail" class="w-full border px-4 py-2 rounded-md" />
        <textarea rows="4" placeholder="Your message" class="w-full border px-4 py-2 rounded-md"></textarea>
        <button type="submit" class="bg-[#0A1C64] hover:bg-[#162996] text-white px-6 py-3 rounded-md font-semibold w-full">
          Send Message
        </button>
      </form>
    </div>
  </section>

  <!-- Newsletter -->
  <section class="bg-[#162996] px-4 md:px-12">
    <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4 md:gap-6 px-4 md:px-6 py-8 md:py-12">
      <div data-aos="fade-right">
        <h3 class="text-lg md:text-xl font-semibold mb-2 md:mb-4">Subscribe to our newsletter</h3>
        <p class="text-sm md:text-base">Wonderful platform with easy to do task to make money, i got paid instantly</p>
      </div>
      <div class="flex w-full md:w-auto" data-aos="fade-left">
        <input type="email" placeholder="Enter Your Email Address" class="w-full md:w-80 px-4 py-2 rounded-l-md text-black" />
        <button class="bg-yellow-400 text-black px-4 md:px-6 rounded-r-md font-semibold">Join</button>
      </div>
    </div>
  </section>
</div>
  @include('components.footer')
</body>
</html>

