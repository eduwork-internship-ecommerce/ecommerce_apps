@props(['slides'])

<div x-data="{ activeSlide: 0, slides: @js($slides) }" class="relative w-full h-screen overflow-hidden">
    <div class="absolute inset-0">
        <template x-for="(slide, index) in slides" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out"
                 x-show="activeSlide === index"
                 x-transition:enter="opacity-0"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="opacity-100"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 :style="{ 'background-image': `url(${slide.image})` }"
                 style="background-size: cover; background-position: center;">
                
                <div class="absolute inset-0 bg-black opacity-50"></div>
                
                <div class="relative flex items-center justify-center h-full text-center text-white p-4">
                    <div class="max-w-4xl mx-auto">
                        {{-- Remove Tailwind's text-size classes and use h1 tag --}}
                        <h1 class="font-bold leading-tight mb-4 drop-shadow-lg"
                            x-text="slide.title"></h1>
                        {{-- Remove Tailwind's text-size classes and use p tag --}}
                        <p class="font-light mb-8 drop-shadow-md"
                            x-text="slide.description"></p>
                        <a href="#" class="inline-block bg-amber-500 text-gray-900 font-semibold py-3 px-8 rounded-full shadow-lg hover:bg-amber-400 transition-colors duration-300">
                            Lihat Produk
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </div>

    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-2 z-10">
        <template x-for="(slide, index) in slides" :key="index">
            <button @click="activeSlide = index"
                    class="w-3 h-3 rounded-full bg-white transition-all duration-300"
                    :class="{ 'opacity-100 scale-125': activeSlide === index, 'opacity-50': activeSlide !== index }">
            </button>
        </template>
    </div>

    <div x-init="setInterval(() => activeSlide = (activeSlide + 1) % slides.length, 5000)"></div>
</div>