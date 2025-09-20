@php
    $heroSlides = [
        [
            'image' => asset('images/hero2-bg-madu.jpg'),
            'title' => '🍯 Nikmati Kelezatan Madu Murni Terbaik',
            'description' => 'Madu berkualitas tinggi langsung dari peternak lebah lokal.'
        ],
        [
            'image' => asset('images/hero3-bg-madu.jpg'),
            'title' => '🐝 Madu Organik, Manis Alami dan Sehat',
            'description' => 'Dipanen dari sarang lebah terbaik, tanpa bahan kimia berbahaya.'
        ],
        [
            'image' => asset('images/hero4-bg-madu.jpg'),
            'title' => '📦 Pesan Sekarang, Madu Sampai di Pintu Anda',
            'description' => 'Pengiriman cepat dan aman ke seluruh Indonesia.'
        ]
    ];
@endphp
<x-main-layout>
    <x-hero :slides="$heroSlides" />
   <x-contact-us />
</x-main-layout>
