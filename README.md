<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
| <a href="https://github.com/laravel/framework/actions">Build Status</a> | <a href="https://packagist.org/packages/laravel/framework">Total Downloads</a> | <a href="https://packagist.org/packages/laravel/framework">Latest Stable Version</a> | <a href="https://packagist.org/packages/laravel/framework">License</a> |
| :---: | :---: | :---: | :---: |
</p>

# 🍯 Proyek E-Commerce HoneyMart

**HoneyMart** adalah solusi *Fullstack E-Commerce* modern yang berfokus pada penjualan produk madu murni. Aplikasi ini dibangun dengan mengutamakan performa, kemudahan navigasi bagi pengguna, dan proses transaksi yang terintegrasi penuh.

## 🛠️ Tumpukan Teknologi & Infrastruktur

Proyek ini dikembangkan menggunakan arsitektur modern.

| Kategori | Teknologi | Deskripsi Implementasi |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel** | Inti dari sistem, mengelola routing, logika bisnis, ORM (Eloquent), dan API. |
| **Frontend Styling** | **Tailwind CSS** | Digunakan untuk desain responsif, cepat, dan modern. |
| **Payment Gateway** | **Midtrans** | Integrasi pembayaran pihak ketiga yang mendukung berbagai metode pembayaran. |
| **Email Service** | **SMTP** | Implementasi SMTP untuk mengirim email konfirmasi registrasi akun. |

## ✨ Fitur Utama (Core Features)

### 1. Pengalaman Pengguna
* **Halaman Beranda yang Atraktif:** Menampilkan *hero section* yang menarik.
* **Sistem Filter Produk:** Memudahkan pengguna mencari produk dengan *filter* berdasarkan **Brand** dan **Kategori** di Halaman Produk.

### 2. Manajemen Transaksi
* **Integrated Checkout:** Proses *checkout* terintegrasi dengan Midtrans, memastikan transaksi yang aman.
* **Verifikasi Pembayaran Manual:** Status pembayaran disetujui setelah konfirmasi dari Admin (via WhatsApp/sistem).
* **Riwayat Pesanan:** Pengguna dapat melihat detail dan status pesanan mereka.

### 3. Otentikasi & Keamanan
* **Verifikasi Akun Otomatis:** Setiap pengguna baru wajib memverifikasi email yang dikirimkan melalui **SMTP** saat pendaftaran.
* **Multi-Role:** Pembagian akses yang jelas antara **Admin** (Pengelola) dan **User** (Pelanggan).

## 💻 Struktur Halaman

### A. Dashboard Admin

Dashboard ini memberikan kendali penuh kepada pengelola toko dengan tampilan ringkasan data kunci.

| # | Menu | Deskripsi |
| :---: | :--- | :--- |
| 1 | **Dasbor** | Ringkasan statistik cepat (Produk: 4, Kategori: 6, Total Stok: 53, Total Transaksi: 9). |
| 2 | **Produk & Kategori** | Manajemen Inventori (CRUD) dan klasifikasi produk. |
| 3 | **Pelanggan** | Melihat dan mengelola data pengguna terdaftar. |
| 4 | **Transaksi** | Detail dan pengelolaan semua pesanan yang masuk. |
| 5 | **Laporan** | Melihat laporan penjualan dan aktivitas toko. |

### B. Halaman Pengguna

Halaman yang berorientasi pada transaksi dan informasi produk.

| # | Halaman | Deskripsi |
| :---: | :--- | :--- |
| 1 | **Beranda / Tentang Kami** | Informasi produk dan perusahaan. |
| 2 | **Produk** | Katalog lengkap dengan opsi filter dan pencarian. |
| 3 | **Keranjang Belanja** | Mengelola item sebelum proses *checkout*. |
| 4 | **Riwayat Pesanan** | Menampilkan semua pesanan pengguna, termasuk kode transaksi dan status. |

## 💾 Desain Database (Skema Utama)

Skema database menggunakan struktur relasional. Tabel utama meliputi `orders`, `order_items`, dan `order_shipping_addresses`.

### 1. Tabel `orders` (Tabel Transaksi Utama)

Tabel ini menyimpan data transaksi dasar.

| Kolom | Datatype | Keterangan |
| :--- | :--- | :--- |
| `id` | `BIGINT` | ID Pesanan Unik (PK) |
| `user_id` | `BIGINT` | Pemilik pesanan (FK ke `users`) |
| `code` | `VARCHAR` | Kode Unik Pesanan |
| `status` | `ENUM` | Status Proses (`pending`, `completed`, `processing`, `shipped`, `canceled`) |
| `grand_total` | `DECIMAL(12,2)` | Total Akhir Pembayaran |
| `payment_method` | `VARCHAR` | Metode Pembayaran |
| `payment_status` | `ENUM` | Status Pembayaran (`unpaid`, `paid`) |

### 2. Tabel `order_items` (Detail Item Pesanan)

Mencatat detail setiap produk yang dibeli pada satu pesanan.

| Kolom | Datatype | Keterangan |
| :--- | :--- | :--- |
| `id` | `BIGINT` | ID Unik |
| `order_id` | `BIGINT` | Relasi ke Pesanan Utama |
| `product_id` | `BIGINT` | Produk yang dibeli |
| `product_name_snapshot` | `VARCHAR(255)` | Nama produk saat dibeli |
| `price_snapshot` | `DECIMAL(12,2)` | Harga per unit saat dibeli |
| `quantity` | `INT(11)` | Jumlah item |
| `subtotal` | `DECIMAL(12,2)` | Total harga untuk item ini |

### 3. Tabel `order_shipping_addresses` (Detail Alamat Pengiriman)

Mencatat alamat pengiriman spesifik untuk pesanan tersebut.

| Kolom | Datatype | Keterangan |
| :--- | :--- | :--- |
| `id` | `BIGINT` | ID Unik |
| `order_id` | `BIGINT` | Relasi ke Pesanan Utama |
| `recipient_name` | `VARCHAR(255)` | Nama Penerima |
| `address_line` | `VARCHAR(255)` | Alamat Lengkap |
| `city` | `VARCHAR(255)` | Kota |
| `province` | `VARCHAR(255)` | Provinsi |
| `postal_code` | `VARCHAR(255)` | Kode Pos |

## 🚀 Panduan Instalasi

Untuk menjalankan proyek ini secara lokal:

1. **Clone Repositori:**
    ```bash
    git clone [https://www.andarepository.com/](https://www.andarepository.com/)
    cd HoneyMart
    ```

2. **Instal Dependensi:**
    ```bash
    composer install
    npm install
    ```

3. **Konfigurasi Lingkungan:**
    * Duplikat file `.env.example` menjadi `.env`.
    * Atur koneksi database, kredensial **SMTP**, dan **Midtrans API Key**.

4. **Migrasi Database:**
    ```bash
    php artisan migrate --seed
    ```

5. **Kompilasi Assets:**
    ```bash
    npm run dev
    ```

6. **Jalankan Server:**
    ```bash
    php artisan serve
    ```
```eof