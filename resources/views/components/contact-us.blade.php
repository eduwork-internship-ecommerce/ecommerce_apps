<div id="contact" class="bg-amber-50 grid grid-cols-1 md:grid-cols-2">
    <div>
        <img src="{{ asset('images/honey-1.jpg') }}" alt="Contact Us" class="w-full h-full object-cover">
    </div>
    <div class="container mx-auto px-4 md:px-8 lg:px-16 py-16 md:py-24">
        <div class="max-w-3xl mx-auto text-center mb-12">
            {{-- Remove Tailwind's text-size classes and let h2 from style.css handle the size --}}
            <h2 class="font-bold text-gray-800 mb-4">Hubungi Kami 🐝</h2>
            {{-- Remove Tailwind's text-size class and let the body's font-size from style.css handle the size --}}
            <p class="text-gray-600">
                Punya pertanyaan? Kirim pesan kepada kami dan tim kami akan segera membalasnya.
            </p>
        </div>
        <div class="max-w-lg mx-auto bg-white p-6 md:p-10 rounded-lg shadow-lg">
            <form action="#" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        {{-- The label text will inherit the body's font-size from style.css --}}
                        <label for="name" class="block font-medium text-gray-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                    </div>
                    <div>
                        {{-- The label text will inherit the body's font-size from style.css --}}
                        <label for="email" class="block font-medium text-gray-700 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200">
                    </div>
                </div>
                <div class="mb-6">
                    {{-- The label text will inherit the body's font-size from style.css --}}
                    <label for="message" class="block font-medium text-gray-700 mb-1">Pesan Anda</label>
                    <textarea id="message" name="message" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-md focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"></textarea>
                </div>
                <button type="submit" class="w-full bg-amber-500 text-white font-semibold py-3 rounded-md hover:bg-amber-600 transition-colors duration-300">
                    Kirim Pesan
                </button>
            </form>
        </div>
    </div>
</div>