@extends('layouts.mainLayout')

@section('title', 'Halaman Checkout')

@section('content')
<div class="container mx-auto p-4 md:p-8">

    {{-- Pesan Error/Sukses --}}
    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
        <strong class="font-bold">Gagal!</strong>
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <h1 class="text-3xl font-bold mb-6 text-gray-800 border-b pb-2">Konfirmasi Checkout</h1>

    {{-- FORM ALAMAT PENGIRIMAN (Langkah 1: Disimpan ke Session/DB) --}}
    <form id="addressForm" class="space-y-8">
        @csrf
        <div class="bg-white p-6 shadow-md rounded-lg border" id="addressSection">
            <h2 class="text-xl font-semibold mb-4 text-gray-700">1. Detail Pengiriman 🚚</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="recipient_name" class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                    <input type="text" id="recipient_name" name="recipient_name" value="{{ old('recipient_name') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('recipient_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700">Nomor Telepon</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="address_line" class="block text-sm font-medium text-gray-700">Alamat Lengkap</label>
                <textarea id="address_line" name="address_line" rows="3" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('address_line') }}</textarea>
                @error('address_line') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-4">
                <div>
                    <label for="city" class="block text-sm font-medium text-gray-700">Kota/Kabupaten</label>
                    <input type="text" id="city" name="city" value="{{ old('city') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('city') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="province" class="block text-sm font-medium text-gray-700">Provinsi</label>
                    <input type="text" id="province" name="province" value="{{ old('province') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('province') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Kode Pos</label>
                    <input type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') }}" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">
                    @error('postal_code') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-4">
                <label for="note" class="block text-sm font-medium text-gray-700">Catatan Tambahan (Opsional)</label>
                <textarea id="note" name="note" rows="2" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2">{{ old('note') }}</textarea>
            </div>
            <button type="button" id="saveAddressBtn" class="mt-4 w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 rounded-lg transition duration-200">
                Simpan Alamat Pengiriman
            </button>
        </div>
    </form>
    
    {{-- FORM CHECKOUT (Langkah 2: Proses Pembayaran Midtrans) --}}
    <form id="checkoutForm" method="POST" action="{{ route('checkout.pay') }}" class="flex flex-col lg:flex-row gap-8">
        @csrf

        {{-- Kolom Kiri: Metode Pengiriman --}}
        <div class="lg:w-2/3 space-y-8">
            <div class="bg-white p-6 shadow-md rounded-lg border" id="shippingSection">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">2. Pilih Kurir & Layanan 📦</h2>
                <div class="space-y-3">
                    @foreach($shippingMethods as $method)
                    <label class="flex items-center space-x-3 cursor-pointer p-3 border rounded-md hover:bg-gray-50">
                        <input type="radio" name="shipping_method" value="{{ $method['name'] }}" data-fee="{{ $method['fee'] }}" required
                            class="h-4 w-4 text-indigo-600 border-gray-300 focus:ring-indigo-500 shipping-option"
                            {{ old('shipping_method') == $method['name'] ? 'checked' : '' }}>
                        <span class="text-gray-900 font-medium">{{ $method['name'] }}</span>
                        <span class="text-sm text-gray-600">- Estimasi {{ $method['days'] }}</span>
                        <span class="ml-auto font-semibold text-right">Rp {{ number_format($method['fee']) }}</span>
                    </label>
                    @endforeach
                    @error('shipping_method') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Ringkasan Pesanan --}}
        <div class="lg:w-1/3">
            <div class="bg-white p-6 shadow-xl rounded-lg sticky top-4 border-2 border-indigo-200">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Ringkasan Pembayaran</h2>

                {{-- Daftar Item --}}
                <ul class="divide-y divide-gray-200 mb-4">
                    @foreach($cartItems as $item)
                    <li class="py-2 flex justify-between text-sm">
                        <span class="text-gray-700">{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        <span class="font-medium">Rp {{ number_format($item->product->price * $item->quantity) }}</span>
                    </li>
                    @endforeach
                </ul>

                {{-- Detail Biaya --}}
                <div class="border-t pt-4 space-y-2 text-gray-600">
                    <div class="flex justify-between">
                        <span>Subtotal Produk:</span>
                        <span class="font-medium">Rp {{ number_format($subtotal) }}</span>
                    </div>

                    <div class="flex justify-between">
                        <span>Biaya Pengiriman:</span>
                        <span id="shippingFeeDisplay" class="font-medium text-red-600">Rp 0</span>
                    </div>

                    @php
                    $taxRate = 0.11;
                    $taxTotal = $subtotal * $taxRate;
                    @endphp
                    <div class="flex justify-between">
                        <span>PPN ({{ $taxRate * 100 }}%):</span>
                        <span class="font-medium">Rp {{ number_format($taxTotal) }}</span>
                    </div>
                </div>

                {{-- Total Akhir --}}
                <div class="border-t border-indigo-300 mt-4 pt-4 flex justify-between items-center text-lg font-bold">
                    <span>Total Bayar:</span>
                    <span id="grandTotalDisplay" class="text-indigo-600">Rp {{ number_format($subtotal + $taxTotal) }}</span>
                </div>
                
                {{-- INPUT HIDDEN PENTING UNTUK CONTROLLER --}}
                <input type="hidden" name="total" id="totalInput" value="">
                <input type="hidden" name="shipping_fee_value" id="shippingFeeInput" value="0"> 

                {{-- Tombol Submit Midtrans --}}
                <button type="button" id="midtransPayBtn" class="mt-6 w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 rounded-lg transition duration-200">
                    Selesaikan Pembayaran
                </button>
            </div>
        </div>
    </form>
</div>

{{-- MIDTRANS SDK --}}
<script type="text/javascript"
    src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ config('midtrans.client_key') }}"></script>

<script>
    // Perbaikan sintaks Blade di JS
    const subtotal = {{ $subtotal }};
    const taxTotal = {{ round($taxTotal) }}; // Pastikan PPN dihitung dan dibulatkan dengan benar

    const shippingOptions = document.querySelectorAll('.shipping-option');
    const shippingFeeDisplay = document.getElementById('shippingFeeDisplay');
    const grandTotalDisplay = document.getElementById('grandTotalDisplay');
    const totalInput = document.getElementById('totalInput');
    const shippingFeeInput = document.getElementById('shippingFeeInput'); // Dapatkan input hidden untuk fee

    const addressForm = document.getElementById('addressForm');
    const saveAddressBtn = document.getElementById('saveAddressBtn');
    const midtransPayBtn = document.getElementById('midtransPayBtn');
    const checkoutForm = document.getElementById('checkoutForm');
    
    let isAddressSaved = false;
    let initialSaveAddressBtnText = saveAddressBtn.textContent;


    function formatRupiah(number) {
        // Memastikan input adalah angka, membulatkan, dan memformat
        return 'Rp ' + Math.round(number).toLocaleString('id-ID'); 
    }

    // FUNGSI UTAMA UNTUK MENGHITUNG TOTAL
    function calculateGrandTotal() {
        let selectedFee = 0;
        const selectedOption = document.querySelector('.shipping-option:checked');
        
        if (selectedOption) {
            selectedFee = parseInt(selectedOption.dataset.fee); 
        }

        const grandTotal = subtotal + taxTotal + selectedFee;
        
        // Memperbarui tampilan
        shippingFeeDisplay.textContent = formatRupiah(selectedFee);
        grandTotalDisplay.textContent = formatRupiah(grandTotal);
        
        // Update input hidden untuk dikirim ke backend
        totalInput.value = grandTotal; 
        shippingFeeInput.value = selectedFee; 
    }

    // FUNGSI 1: Menyimpan Alamat
    saveAddressBtn.addEventListener('click', async function(e) {
        e.preventDefault();
        
        // Jika statusnya sudah tersimpan, izinkan edit
        if (isAddressSaved) {
            document.querySelectorAll('#addressSection input, #addressSection textarea').forEach(el => el.disabled = false);
            saveAddressBtn.textContent = initialSaveAddressBtnText;
            saveAddressBtn.classList.remove('bg-gray-500');
            saveAddressBtn.classList.add('bg-blue-500');
            isAddressSaved = false;
            // midtransPayBtn.classList.add('hidden'); // Sembunyikan tombol bayar saat edit
            return;
        }

        // Ambil data form alamat
        const formData = new FormData(addressForm);
        
        // Tambahkan loader/disable tombol saat proses
        saveAddressBtn.textContent = 'Menyimpan...';
        saveAddressBtn.disabled = true;

        try {
            const response = await fetch("{{ route('checkout.save_address') }}", { 
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });

            const data = await response.json();

            saveAddressBtn.disabled = false;
            saveAddressBtn.textContent = initialSaveAddressBtnText;

            if (data.error) {
                alert("Gagal menyimpan alamat: " + data.error);
                return;
            }
            
            alert(data.message);
            isAddressSaved = true;
            
            // Ubah tampilan: Nonaktifkan form alamat
            document.querySelectorAll('#addressSection input, #addressSection textarea').forEach(el => el.disabled = true);
            saveAddressBtn.textContent = 'Alamat Tersimpan (Ubah)';
            saveAddressBtn.classList.remove('bg-blue-500');
            saveAddressBtn.classList.add('bg-gray-500');

            // midtransPayBtn.classList.remove('hidden'); // Tampilkan tombol bayar setelah alamat tersimpan
            
        } catch (error) {
            saveAddressBtn.disabled = false;
            saveAddressBtn.textContent = initialSaveAddressBtnText;
            console.error("Save Address Gagal:", error);
            alert("Terjadi kesalahan koneksi saat menyimpan alamat.");
        }
    });

    // FUNGSI 2: Proses Pembayaran Midtrans
    midtransPayBtn.addEventListener('click', async function(e) {
        e.preventDefault();

        if (!isAddressSaved) {
            alert("Harap Simpan Alamat Pengiriman terlebih dahulu (Klik tombol Simpan Alamat Pengiriman).");
            return;
        }

        const selectedShipping = document.querySelector('.shipping-option:checked');
        if (!selectedShipping) {
            alert("Harap pilih Kurir & Layanan terlebih dahulu.");
            return;
        }

        // Pastikan input-input tersembunyi terisi dengan total yang benar
        calculateGrandTotal(); 

        const formData = new FormData(checkoutForm);
        
        midtransPayBtn.textContent = 'Memproses Pembayaran...';
        midtransPayBtn.disabled = true;

        try {
            const response = await fetch(checkoutForm.action, {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                body: formData
            });

            const data = await response.json();
            midtransPayBtn.textContent = 'Selesaikan Pembayaran';
            midtransPayBtn.disabled = false;

            if (data.error) {
                alert("Gagal membuat transaksi: " + data.error);
                console.error("Backend Error:", data.error);
                return;
            }

            // Panggil Snap Midtrans
            window.snap.pay(data.snapToken, {
                onSuccess: function(result) {
                    alert("Pembayaran Berhasil!");
                    window.location.href = "{{ url('checkout/finish') }}/" + data.order_code; 
                },
                onPending: function(result) {
                    alert("Menunggu Pembayaran...");
                    window.location.href = "{{ url('checkout/finish') }}/" + data.order_code; 
                },
                onError: function(result) {
                    alert("Terjadi Kesalahan!");
                    window.location.href = "{{ url('checkout/finish') }}/" + data.order_code; 
                },
                onClose: function() {
                    alert("Anda menutup popup.");
                    window.location.href = "{{ url('checkout/finish') }}/" + data.order_code; 
                }
            });
        } catch (error) {
            midtransPayBtn.textContent = 'Selesaikan Pembayaran';
            midtransPayBtn.disabled = false;
            console.error("Fetch gagal:", error);
            alert("Terjadi kesalahan koneksi ke server.");
        }
    });


    // Listener Saat Halaman Dimuat dan Opsi Kurir Berubah
    document.addEventListener('DOMContentLoaded', function() {
        calculateGrandTotal();
        shippingOptions.forEach(option => {
            option.addEventListener('change', calculateGrandTotal);
        });
    });

    // Hapus handler submit lama pada form checkout agar tidak bentrok dengan tombol Midtrans
    document.getElementById('checkoutForm').addEventListener('submit', function(e) {
        e.preventDefault();
    });
</script>
@endsection