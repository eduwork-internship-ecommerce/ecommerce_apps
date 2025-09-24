<style>
  /* Pure CSS for the mobile menu toggle */
  #menu-toggle:checked+#menu-container {
    display: flex;
    flex-direction: column;
  }
</style>

<nav class="sticky top-0 bg-[#2A1E1A] px-4 py-2 z-50">
  <div class="flex items-center justify-between">

    <div class="flex items-center">
      <a href="home">
        <img src="{{ asset('images/honey-mart-logo.png') }}" alt="Logo" class="h-14 w-auto">
      </a>
      <span class="ml-2 font-bold text-xl text-[#D9A24D]">HONEYMART</span>
    </div>

    <div class="hidden md:flex flex-1 justify-center gap-x-8">
      <a href="home" class="font-semibold text-[#D9A24D] border-b-2 border-[#D9A24D]">Beranda</a>
      <a href="#" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Produk</a>
      <a href="#" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Categories</a>
      <a href="#" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Tentang Kami</a>
      <a href="#" class="text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Hunbungi Kami</a>
    </div>

    <div class="flex items-center gap-x-4">
      <a href="/search" class="text-[#D9A24D] hover:text-yellow-600 transition-colors duration-200">
        <svg class="fill-current" width="24" height="25" viewBox="0 0 70 69" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M53.7105 47.6416L68.9813 62.9308C69.6633 63.6893 69.6297 64.8505 68.905 65.5682L66.2326 68.2438C65.8742 68.6056 65.3863 68.8092 64.8773 68.8092C64.3683 68.8092 63.8804 68.6056 63.522 68.2438L48.2512 52.9546C47.8288 52.5313 47.4455 52.0708 47.1058 51.5785L44.2426 47.7562C39.505 51.5439 33.6219 53.6061 27.5592 53.6044C15.0661 53.6478 4.21013 45.0195 1.41826 32.8276C-1.37361 20.6358 4.64375 8.1342 15.9079 2.72422C27.172 -2.68575 40.6767 0.439701 48.4268 10.2502C56.1768 20.0607 56.1039 33.938 48.2512 43.6664L52.0689 46.3037C52.6651 46.6858 53.2158 47.1346 53.7105 47.6416ZM8.47051 26.8482C8.47051 37.4032 17.0167 45.9598 27.5591 45.9598C32.6217 45.9598 37.4769 43.9462 41.0567 40.3621C44.6365 36.778 46.6476 31.9169 46.6476 26.8482C46.6476 16.2932 38.1014 7.73662 27.5591 7.73662C17.0167 7.73662 8.47051 16.2932 8.47051 26.8482Z"></path>
        </svg>
      </a>
      <a href="/cart" class="text-[#D9A24D] hover:text-yellow-600 transition-colors duration-200">
        <svg class="fill-current" width="24" height="24" viewBox="0 0 69 69" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd" d="M13.1158 6.90773H66.9046C67.8459 6.90773 68.609 7.67079 68.609 8.61207V10.3164C68.5843 13.1452 67.8205 15.9184 66.3933 18.3609L58.383 32.4387C56.6496 35.5541 53.3916 37.5141 49.8272 37.5858H28.5912C27.8544 37.5699 27.1222 37.467 26.4096 37.279L23.001 44.4031H60.0873C61.0286 44.4031 61.7916 45.1662 61.7916 46.1075V49.5161C61.7916 50.4574 61.0286 51.2205 60.0873 51.2205H17.4789C16.5461 51.242 15.6737 50.7603 15.1951 49.9593L14.4452 48.664C14.0511 47.9054 14.0511 47.0024 14.4452 46.2438L20.7853 33.6317C20.4391 33.2661 20.1307 32.8664 19.865 32.4387L5.27586 6.90773H2.13988C1.1986 6.90773 0.435547 6.14467 0.435547 5.20339V1.79472C0.435547 0.853443 1.1986 0.090386 2.13988 0.090386H5.27586C7.72114 0.0806781 9.98432 1.38136 11.2069 3.49906L13.1158 6.90773ZM20.8874 54.6292C17.1222 54.6292 14.07 57.6814 14.07 61.4465C14.07 65.2116 17.1222 68.2638 20.8874 68.2638C24.6525 68.2638 27.7047 65.2116 27.7047 61.4465C27.7047 57.6814 24.6525 54.6292 20.8874 54.6292ZM61.7914 61.4465C61.7914 65.2116 58.7392 68.2638 54.9741 68.2638C51.209 68.2638 48.1567 65.2116 48.1567 61.4465C48.1567 57.6814 51.209 54.6292 54.9741 54.6292C58.7392 54.6292 61.7914 57.6814 61.7914 61.4465Z"></path>
        </svg>
      </a>
      <x-user.dropdown-user />
      <label for="menu-toggle" class="md:hidden cursor-pointer text-[#D9A24D] hover:text-[#FFF4E7]">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
        </svg>
      </label>
    </div>
  </div>

  <input type="checkbox" id="menu-toggle" class="hidden">

  <div id="menu-container" class="hidden absolute top-full left-0 w-full bg-[#2A1E1A] p-6 z-40">
    <a href="home" class="block py-2 font-semibold text-[#D9A24D] border-b-2 border-[#D9A24D]">Beranda</a>
    <a href="#" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Produk</a>
    <a href="#" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Categories</a>
    <a href="#" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#FFF4E7]">Tentang Kami</a>
    <a href="#" class="block py-2 text-[#D9A24D] hover:underline hover:text-[#EED2A4]">Hunbungi Kami</a>
  </div>

</nav>