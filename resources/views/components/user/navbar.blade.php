<style>
  /* Pure CSS for the mobile menu toggle */
  #menu-toggle:checked+#menu-container {
    display: flex;
    flex-direction: column;
  }
</style>

<nav class="sticky top-0 bg-[#2A1E1A] px-6 md:px-12 py-2 z-50">
  <div class="flex items-center justify-between">

    <div class="flex items-center">
      <a href="{{route('home')}}">
        <img src="{{ asset('images/honey-mart-logo.png') }}" alt="Logo" class="h-14 w-auto">
      </a>
      <span class="ml-2 font-bold text-xl text-[#D9A24D]">HONEYMART</span>
    </div>

    <div class="hidden md:flex flex-1 justify-center gap-x-8">
      <a href="{{route('home')}}" class="font-semibold text-[#D9A24D] border-b-2 border-[#D9A24D]">Beranda</a>
      <a href="{{route('products.index')}}" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Produk</a>
      <a href="#" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Tentang Kami</a>
      <a href="#" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Hubungi Kami</a>
    </div>

    <div class="flex items-center gap-x-4">
      {{-- cart --}}
      <a href="/cart" class="text-[#D9A24D] hover:text-yellow-600 transition-colors duration-200">
        <svg class="fill-current" width="24" height="24" viewBox="0 0 69 69" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1158 6.90773H66.9046C67.8459 6.90773 68.609 7.67079 68.609 8.61207V10.3164C68.5843 13.1452 67.8205 15.9184 66.3933 18.3609L58.383 32.4387C56.6496 35.5541 53.3916 37.5141 49.8272 37.5858H28.5912C27.8544 37.5699 27.1222 37.467 26.4096 37.279L23.001 44.4031H60.0873C61.0286 44.4031 61.7916 45.1662 61.7916 46.1075V49.5161C61.7916 50.4574 61.0286 51.2205 60.0873 51.2205H17.4789C16.5461 51.242 15.6737 50.7603 15.1951 49.9593L14.4452 48.664C14.0511 47.9054 14.0511 47.0024 14.4452 46.2438L20.7853 33.6317C20.4391 33.2661 20.1307 32.8664 19.865 32.4387L5.27586 6.90773H2.13988C1.1986 6.90773 0.435547 6.14467 0.435547 5.20339V1.79472C0.435547 0.853443 1.1986 0.090386 2.13988 0.090386H5.27586C7.72114 0.0806781 9.98432 1.38136 11.2069 3.49906L13.1158 6.90773ZM20.8874 54.6292C17.1222 54.6292 14.07 57.6814 14.07 61.4465C14.07 65.2116 17.1222 68.2638 20.8874 68.2638C24.6525 68.2638 27.7047 65.2116 27.7047 61.4465C27.7047 57.6814 24.6525 54.6292 20.8874 54.6292ZM61.7914 61.4465C61.7914 65.2116 58.7392 68.2638 54.9741 68.2638C51.209 68.2638 48.1567 65.2116 48.1567 61.4465C48.1567 57.6814 51.209 54.6292 54.9741 54.6292C58.7392 54.6292 61.7914 57.6814 61.7914 61.4465Z"></path>
        </svg>
      </a>
      @guest
        <div class="hidden md:flex items-center gap-x-3">
            <a href="{{ route('login') }}" class="text-[#D9A24D] font-semibold hover:underline hover:text-[#FFF4E7]">Masuk</a>
            <a href="{{ route('register') }}" class="text-[#D9A24D] font-semibold hover:underline hover:text-[#FFF4E7]">Daftar</a>
        </div>
      @endguest
      @auth
        <div class="hidden md:block">
            <x-user.dropdown-user />
        </div>
      @endauth
      
      <label for="menu-toggle" class="md:hidden cursor-pointer text-[#D9A24D] hover:text-[#FFF4E7]">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </label>
    </div>
  </div>

  <input type="checkbox" id="menu-toggle" class="hidden">

  <div id="menu-container" class="hidden absolute top-full left-0 w-full bg-[#2A1E1A] p-6 z-40">
    @auth
      <div class="mb-4 pb-2 border-b-2 border-[#D9A24D]">
        <p class="font-bold text-lg text-[#EED2A4]">{{ Auth::user()->name }}</p>
        <p class="text-sm text-gray-400">{{ Auth::user()->email }}</p>
      </div>
      <a href="{{ route('profile.edit') }}" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Profil</a>
      <form method="POST" action="{{ route('logout') }}" class="block py-2">
        @csrf
        <button type="submit" class="w-full text-left font-semibold text-red-500 hover:text-red-400 transition-colors duration-200">
          Keluar
        </button>
      </form>
      
      <div class="border-t border-[#D9A24D] my-4"></div>
    @endauth
    
    @guest
      <div class="mb-4 pb-4 border-b border-[#D9A24D]">
        <a href="{{ route('login') }}" class="block py-2 font-semibold text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Masuk</a>
        <a href="{{ route('register') }}" class="block py-2 font-semibold text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Daftar</a>
      </div>
    @endguest

    <a href="{{ route('home') }}" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Beranda</a>
    <a href="{{ route('products.index') }}" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Produk</a>
    <a href="#" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Tentang Kami</a>
    <a href="#" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#EED2A4]">Hubungi Kami</a>
  </div>
</nav>