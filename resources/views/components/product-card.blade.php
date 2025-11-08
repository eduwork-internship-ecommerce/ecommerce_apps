@props(['products', 'bgColors' => ['bg-[#B68B4B]', 'bg-[#EED2A4]', 'bg-[#FFF4E7]', 'bg-[#F0EFE7]']])

<div class="container mx-auto px-4 py-16 md:py-24 bg-white">
    {{-- Section Title --}}
    <div class="text-center mb-12">
        <h2 class="text-4xl md:text-5xl font-playfair font-bold">Popular Products</h2>
    </div>

            {{-- Product Cards --}}
    <div class="relative">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($products as $product)
                <div class="rounded-xl p-6 flex flex-col {{ $bgColors[$loop->index % count($bgColors)] }}">
                    <div class="flex-grow">
                        @if($product->image_url)
                    <a href="{{ route('products.show', $product->slug) }}" class="block mb-4">
                        <div class="w-full h-48 overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/' . $product->image_url) }}" 
                            alt="{{ $product->name }}" 
                                class="w-full h-full object-cover transition-transform duration-300 ease-in-out hover:scale-110 cursor-pointer">
                        </div>
                        </a>
                        <h3 class="text-xl font-semibold text-gray-800">
                            <a href="{{ route('products.show', $product->slug) }}" class="hover:underline">
                                {{ $product->name }}
                            </a>
                        </h3>
                        <p class="font-bold text-gray-800 mb-4">{{ $product->description }}</p>
                        @endif
                    </div>
                    <p class="text-lg font-bold text-gray-900 mt-4">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="w-full flex justify-end pr-2">
        {{ $products->links('vendor.pagination.simple-tailwind') }}
    </div>

    <div class="text-center mt-12">
        <a href="products" class="inline-flex items-center justify-center gap-3 bg-amber-500 text-white py-3 px-8 rounded-lg font-semibold hover:bg-amber-600 transition-colors duration-300 focus:outline-none focus:ring-2 focus:ring-[#9db8b7] focus:ring-offset-2">
            Explore all items
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
            </svg>
        </a>
    </div>
</div>