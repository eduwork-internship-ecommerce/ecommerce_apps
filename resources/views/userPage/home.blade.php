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




@extends('layouts.mainLayout') {{-- Ganti dengan nama layout Anda jika berbeda --}}

@section('title', 'Beranda') {{-- Menetapkan judul halaman --}}

@section('content')
        <x-user.hero :slides="$heroSlides" />
        <x-product-card :paginatedProducts="$paginatedProducts" />
        <x-user.contact-us />
    @endsection