@extends('layouts.mainLayout')

@section('title', 'Tentang Kami')

@section('content')
<div class="bg-white text-gray-800">

    {{-- Bagian Header/Hero Tentang Kami --}}
    <div class="py-20 md:py-32 bg-[var(--dark-brown)] text-[var(--light-cream)] text-center">
        <div class="container mx-auto px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold mb-4 text-[var(--dark-gold)]">
                Kisah di Balik Manisnya HONEYMART
            </h1>
            <p class="text-lg md:text-xl max-w-3xl mx-auto">
                Perjalanan kami dimulai dari sarang lebah hingga ke meja makan Anda, menjamin kualitas dan kemurnian.
            </p>
        </div>
    </div>

    {{-- 1. Bagian Sejarah dan Pengembangan Lahan Sendiri --}}
    <div class="py-16 bg-[var(--faded-white)]">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-extrabold mb-10 text-center text-[var(--dark-brown)]">
                Bermula dari Halaman Sendiri
            </h2>

            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-[var(--dark-gold)]">Awal Mula di Tahun 2020</h3>
                    <p class="text-lg leading-relaxed text-[var(--deep-brown)] mb-4">
                        HONEYMART berawal dari kecintaan pada lebah dan produk alaminya. Sejak tahun <strong>2020</strong>, kami memulai <strong>perkembangbiakan madu di lahan milik sendiri</strong>. Fokus kami adalah menciptakan lingkungan yang optimal bagi lebah, memastikan madu yang dihasilkan adalah yang paling murni dan bergizi.
                    </p>
                    <p class="text-lg leading-relaxed text-[var(--deep-brown)]">
                        Dari sarang yang dirawat dengan cermat, kami mengontrol setiap tahapan, mulai dari penempatan sarang hingga proses panen, menjamin kualitas premium yang konsisten.
                    </p>
                </div>
                <div class="flex justify-center">
                    <img src="images/beekeeping-farming.jpg"
                        alt="beekeeping farming"
                        class="rounded-lg shadow-lg h-80 w-auto ">
                </div>
            </div>
        </div>
    </div>

    {{-- 2. Bagian Madu Hutan Liar (Wild Forest Honey) --}}
    <div class="py-16 bg-white">
        <div class="container mx-auto px-4">
            <h2 class="text-4xl font-extrabold mb-10 text-center text-[var(--dark-brown)]">
                Keajaiban Madu Hutan Pilihan
            </h2>

            <div class="grid md:grid-cols-2 gap-12 items-center flex-row-reverse">

                <div class="flex justify-center">
                    <img src="images/wild-honey.jpg" alt="wild honey" class="rounded-lg shadow-lg h-80 w-full">
                </div>
                <div>
                    <h3 class="text-2xl font-bold mb-4 text-[var(--dark-gold)]">Dipanen dari Alam Liar</h3>
                    <p class="text-lg leading-relaxed text-[var(--deep-brown)] mb-4">
                        Selain madu dari lahan sendiri, kami bangga menyajikan <strong>madu hutan liar</strong> yang kaya akan nutrisi dan rasa unik. Madu ini diambil langsung dari alam, dari hutan-hutan pilihan yang jauh dari polusi.
                    </p>
                    <p class="text-lg leading-relaxed text-[var(--deep-brown)] mb-4">
                        Proses panen dilakukan oleh <strong>tenaga profesional dan berlisensi</strong>. Mereka menerapkan prinsip panen yang lestari, hanya mengambil madu saat panen raya dan meninggalkan sebagian madu untuk kelangsungan hidup koloni lebah.
                    </p>
                    <p class="text-lg leading-relaxed text-[var(--deep-brown)]">
                        Ini adalah komitmen kami terhadap kualitas, etika, dan kelestarian lingkungan.
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. Bagian Kontrol Kualitas & Nilai Inti --}}
    <div class="py-16 bg-[var(--dark-cream)]">
        <div class="container mx-auto px-4">
            <h2 class="text-center text-4xl font-extrabold mb-12 text-[var(--deep-brown)]">Filosofi & Jaminan Kualitas</h2>

            <div class="grid md:grid-cols-3 gap-8 text-center">

                <div class="p-6 rounded-lg bg-[var(--light-cream)] shadow-xl border-t-4 border-[var(--dark-gold)]">
                    <span class="text-5xl mb-3 block text-[var(--dark-gold)]">🔬</span>
                    <h3 class="text-xl font-bold mb-3 text-[var(--dark-brown)]">Uji Laboratorium</h3>
                    <p class="text-[var(--warm-gray)]">Setiap batch madu (baik dari lahan sendiri maupun hutan) melewati uji lab ketat untuk memastikan tidak ada pemalsuan dan memenuhi standar SNI.</p>
                </div>

                <div class="p-6 rounded-lg bg-[var(--light-cream)] shadow-xl border-t-4 border-[var(--dark-gold)]">
                    <span class="text-5xl mb-3 block text-[var(--dark-gold)]">🌱</span>
                    <h3 class="text-xl font-bold mb-3 text-[var(--dark-brown)]">Kesejahteraan Lebah</h3>
                    <p class="text-[var(--warm-gray)]">Kesehatan dan keberlanjutan lebah adalah prioritas utama kami. Kami tidak pernah memanen berlebihan (over-harvesting).</p>
                </div>

                <div class="p-6 rounded-lg bg-[var(--light-cream)] shadow-xl border-t-4 border-[var(--dark-gold)]">
                    <span class="text-5xl mb-3 block text-[var(--dark-gold)]">🌍</span>
                    <h3 class="text-xl font-bold mb-3 text-[var(--dark-brown)]">Dukungan Petani Lokal</h3>
                    <p class="text-[var(--warm-gray)]">Kami bekerja sama secara adil dengan komunitas pemanen madu hutan, mendukung ekonomi lokal.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Panggilan Aksi --}}
    <div class="py-12 bg-[var(--dark-gold)] text-[var(--dark-brown)] text-center">
        <p class="text-2xl font-bold mb-4">Rasakan Perbedaan Madu yang Dipanen dengan Hati.</p>
        <a href="{{ route('products.index') }}"
            class="inline-block px-8 py-3 bg-[var(--dark-brown)] text-[var(--light-cream)] font-semibold rounded-full hover:bg-[var(--deep-brown)] transition duration-300 shadow-lg">
            Jelajahi Pilihan Madu Kami
        </a>
    </div>

</div>
@endsection