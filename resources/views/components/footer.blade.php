<footer class="bg-[var(--warna-coklat-tua)] text-[var(--warna-emas-muda)] py-12 md:py-16">
    <div class="container mx-auto px-4 md:px-8 lg:px-16 grid grid-cols-1 md:grid-cols-5 gap-4">
        <div class="col-span-1 justify-items-center">
            <div class="flex items-center mb-4">
                <img src="{{ asset('images/honey-mart-logo.png') }}" alt="Honey Mart Logo" class="h-50 mr-2">
            </div>
        </div>

        <div>
            {{-- Menggunakan tag h4 agar CSS dari style.css bekerja --}}
            <h4 class="font-semibold mb-4">Jelajahi</h4>
            {{-- Menghapus kelas text-sm dan mengandalkan font-size dari body CSS --}}
            <ul class="space-y-2 text-gray-400">
                <li><a href="#" class="hover:text-white transition-colors duration-200">Beranda</a></li>
                <li><a href="#" class="hover:text-white transition-colors duration-200">Produk</a></li>
                <li><a href="#" class="hover:text-white transition-colors duration-200">Tentang Kami</a></li>
                <li><a href="#" class="hover:text-white transition-colors duration-200">Blog</a></li>
            </ul>
        </div>

        <div class="col-span-2">
            {{-- Menggunakan tag h4 --}}
            <h4 class="font-semibold mb-4">Kontak Kami</h4>
            {{-- Menghapus kelas text-sm dan mengandalkan font-size dari body CSS --}}
            <address class="space-y-2 text-gray-400 not-italic">
                <p>📍 Alamat: Jl. Contoh Madu No. 123, Kota Beehive</p>
                <p>📞 Telepon: +62 812-3456-7890</p>
                <p>📧 Email: <a href="mailto:info@honeymart.com" class="hover:text-white">info@honeymart.com</a></p>
            </address>
        </div>

        <div class="mt-4 md:mt-0">
            {{-- Menggunakan tag h4 --}}
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