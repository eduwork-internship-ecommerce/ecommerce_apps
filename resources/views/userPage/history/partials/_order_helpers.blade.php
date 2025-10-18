{{-- BAGIAN 1: PHP HELPER FUNCTIONS (Untuk Blade) --}}
@php
    // Fungsi helper untuk status dan formatting tanggal (asumsi Carbon tersedia)
    // Catatan: Dalam proyek Laravel nyata, fungsi ini idealnya diletakkan di kelas helper atau View Composers,
    // bukan didefinisikan berulang-ulang di Blade.
    function formatStatus($status) {
        $map = [
            'pending' => 'Menunggu Pembayaran',
            'processing' => 'Diproses',
            'shipped' => 'Dikirim',
            'completed' => 'Selesai',
            'canceled' => 'Dibatalkan',
            'paid' => 'Sudah Dibayar',
            'unpaid' => 'Belum Dibayar',
            'failed' => 'Gagal Bayar',
        ];
        return $map[$status] ?? ucfirst($status);
    }

    function getStatusClass($status) {
        $map = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'processing' => 'bg-blue-100 text-blue-800',
            'shipped' => 'bg-indigo-100 text-indigo-800',
            'completed' => 'bg-green-100 text-green-800',
            'canceled' => 'bg-red-100 text-red-800',
        ];
        return $map[$status] ?? 'bg-gray-100 text-gray-800';
    }

    function formatDate($timestamp) {
        try {
            // Carbon harus diinstal/tersedia
            return \Carbon\Carbon::parse($timestamp)->isoFormat('D MMMM YYYY, HH:mm');
        } catch (\Exception $e) {
            return $timestamp; // Fallback jika Carbon tidak tersedia
        }
    }
@endphp

{{-- BAGIAN 2: JAVASCRIPT HELPER (Untuk Alpine.js di Modal) --}}
<script>
    // Memastikan fungsi PHP formatStatus dan formatDate tersedia di scope global untuk Alpine.js
    window.formatStatus = function(status) {
        const map = {
            'pending': 'Menunggu Pembayaran',
            'processing': 'Diproses',
            'shipped': 'Dikirim',
            'completed': 'Selesai',
            'canceled': 'Dibatalkan',
            'paid': 'Sudah Dibayar',
            'unpaid': 'Belum Dibayar',
            'failed': 'Gagal Bayar',
        };
        return map[status] ?? status.charAt(0).toUpperCase() + status.slice(1);
    };

    window.formatDate = function(timestamp) {
        if (!timestamp) return '-';
        const date = new Date(timestamp);
        if (isNaN(date)) return timestamp;
        return date.toLocaleString('id-ID', {
            year: 'numeric', month: 'long', day: 'numeric',
            hour: '2-digit', minute: '2-digit'
        });
    };

    document.addEventListener('alpine:init', () => {
        // Alpine.data tidak diperlukan lagi karena fungsi sudah dipindahkan ke window object
    });
</script>
