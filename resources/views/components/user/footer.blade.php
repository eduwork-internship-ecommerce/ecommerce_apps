<footer class="footer: bg-[#2A1E1A] text-[#EED2A4] py-6 md:py-12">
    <div class="container mx-auto px-4 md:px-8 lg:px-16 grid grid-cols-1 md:grid-cols-8 gap-4">
        <div class="md:col-span-2">
            <div class="flex items-center mb-4">
                <img src="{{ asset('images/honey-mart-logo.png') }}" alt="Honey Mart Logo" class="h-40 mr-2">
            </div>
        </div>
        <div class="md:col-span-2">
            <h4 class="font-semibold mb-4">Jelajahi</h4>
            <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors duration-200">Beranda</a></li>
                <li><a href="#" class="hover:text-white transition-colors duration-200">Produk</a></li>
                <li><a href="#" class="hover:text-white transition-colors duration-200">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-white transition-colors duration-200">Blog</a></li>
            </ul>
        </div>
        <div class="md:col-span-3">
            <h4 class="font-semibold mb-4">Kontak Kami</h4>
            <address class="space-y-2 text-gray-400 not-italic">
                <p>📍 Alamat: Jl. Contoh Madu No. 123, Kota Beehive</p>
                <p>📞 Telepon: +62 812-3456-7890</p>
                <p>📧 Email: <a href="mailto:info@honeymart.com" class="hover:text-white">info@honeymart.com</a></p>
            </address>
        </div>
        <div class="mt-4 md:mt-0 md:col-span-1">
            <h4 class="font-semibold mb-4">Ikuti Kami</h4>
            <div class="flex space-x-4">
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                    <i class="fa-brands fa-instagram"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                    <i class="fa-brands fa-facebook"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                    <i class="fa-brands fa-twitter"></i>
                </a>
                <a href="#" class="text-gray-400 hover:text-white transition-colors duration-200">
                    <i class="fa-brands fa-youtube"></i>
                </a>
            </div>
        </div>
    </div>
    <div class="container mx-auto px-4 md:px-8 lg:px-16 mt-8 border-t border-gray-700 pt-6 text-center text-gray-500">
        {{-- Mengandalkan font-size dari body CSS, atau bisa menggunakan tag p --}}
        <p>&copy; {{ date('Y') }} Honey Mart. Semua hak cipta dilindungi.</p>
    </div>
</footer>