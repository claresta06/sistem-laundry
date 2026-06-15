🧺 LaundryGlow – Sistem Manajemen Laundry Berbasis Web

   

📖 Deskripsi Project

LaundryGlow merupakan aplikasi manajemen laundry berbasis web yang dibuat untuk membantu proses pengelolaan usaha laundry secara digital. Sistem ini memungkinkan admin untuk mengelola data pelanggan, paket laundry, transaksi, serta memantau status pengerjaan dan pembayaran laundry secara lebih mudah, cepat, dan terorganisir.

Aplikasi ini dibangun menggunakan:

Laravel 12 sebagai framework backend

PHP 8.2 sebagai bahasa pemrograman

MySQL sebagai database

Blade Template sebagai template engine

Bootstrap/CSS Custom untuk tampilan antarmuka (UI)


Sistem memiliki desain modern dengan tema Dark Mode Neon Gradient sehingga memberikan pengalaman pengguna yang menarik dan nyaman.


---

🎯 Tujuan Pembuatan Project

Adapun tujuan dari pembuatan aplikasi ini adalah:

1. Mempermudah pengelolaan data pelanggan laundry.


2. Mempermudah pencatatan transaksi laundry.


3. Mengurangi kesalahan pencatatan secara manual.


4. Memantau status pengerjaan laundry secara real-time.


5. Mengetahui total pendapatan dari transaksi yang dilakukan.


6. Menyimpan riwayat transaksi secara terstruktur.




---

✨ Fitur Utama

1. Dashboard

Dashboard berfungsi sebagai halaman utama yang menampilkan ringkasan informasi sistem, antara lain:

Total pendapatan laundry

Jumlah cucian yang sedang diproses

Jumlah pelanggan

Riwayat transaksi terbaru


Fungsi Dashboard

Memberikan informasi secara cepat kepada admin.

Memudahkan monitoring aktivitas laundry.

Menampilkan statistik bisnis secara ringkas.



---

2. Manajemen Pelanggan

Fitur ini digunakan untuk mengelola data pelanggan laundry.

Data yang disimpan:

Nama pelanggan

Nomor telepon

Alamat pelanggan


Fitur:

✅ Tambah pelanggan

✅ Edit data pelanggan

✅ Hapus pelanggan

✅ Menampilkan daftar pelanggan

Tujuan:

Mempermudah admin dalam menyimpan dan mengelola informasi pelanggan secara terpusat.


---

3. Manajemen Paket Laundry

Fitur ini digunakan untuk mengelola jenis layanan laundry.

Data yang disimpan:

Nama paket

Jenis paket

Harga per satuan


Jenis Paket:

Kiloan (/Kg)

Satuan (/Pcs)


Fitur:

✅ Tambah paket

✅ Edit paket

✅ Hapus paket

✅ Menampilkan daftar paket

Contoh:

Nama Paket	Jenis	Harga

Paket Cuci Kering	Kiloan	Rp7.000/Kg
Paket Setrika	Satuan	Rp5.000/Pcs



---

4. Transaksi Laundry

Fitur transaksi digunakan untuk mencatat seluruh layanan laundry yang dilakukan pelanggan.

Data transaksi:

Kode Invoice

Nama pelanggan

Paket laundry

Jumlah (Qty)

Total pembayaran

Tanggal masuk

Status proses

Status pembayaran


Fitur:

✅ Menambah transaksi baru

✅ Menampilkan riwayat transaksi

✅ Melihat detail transaksi

✅ Menghapus transaksi


---

📄 Detail Transaksi

Pada halaman detail transaksi, sistem menampilkan:

Informasi Invoice

Nomor Invoice

Tanggal Masuk

Tanggal Ambil

Nama Kasir


Informasi Pelanggan

Nama pelanggan

Nomor telepon

Alamat


Informasi Layanan

Nama paket

Jumlah laundry

Tarif

Total pembayaran


Catatan Khusus

Contoh:

> "Baju putih jangan dicampur."




---

🔄 Manajemen Status Laundry

Admin dapat mengubah status proses pengerjaan laundry.

Status Proses

1. Antri (Menunggu)


2. Dicuci


3. Dikeringkan


4. Disetrika


5. Selesai


6. Sudah Diambil



Status Pembayaran

Belum Lunas

Lunas


Fungsi:

Memudahkan admin dan pelanggan dalam mengetahui perkembangan proses laundry.


---

📊 Alur Sistem

Admin Login
      │
      ▼
Tambah Data Pelanggan
      │
      ▼
Tambah Paket Laundry
      │
      ▼
Buat Transaksi Baru
      │
      ▼
Generate Invoice
      │
      ▼
Update Status Laundry
      │
      ▼
Transaksi Selesai


---

🗂 Struktur Menu Aplikasi

Dashboard
│
├── Pelanggan
│     ├── Tambah Pelanggan
│     ├── Edit Pelanggan
│     └── Hapus Pelanggan
│
├── Paket Laundry
│     ├── Tambah Paket
│     ├── Edit Paket
│     └── Hapus Paket
│
└── Transaksi Laundry
      ├── Tambah Transaksi
      ├── Riwayat Transaksi
      ├── Detail Invoice
      ├── Update Status
      └── Hapus Transaksi


---

🛠 ERD Sederhana

Tabel Pelanggan

Field	Type

id	bigint
nama	varchar
telepon	varchar
alamat	text
created_at	timestamp
updated_at	timestamp



---

Tabel Paket

Field	Type

id	bigint
nama_paket	varchar
jenis_paket	enum
harga	integer
created_at	timestamp
updated_at	timestamp



---

Tabel Transaksi

Field	Type

id	bigint
invoice	varchar
pelanggan_id	bigint
paket_id	bigint
qty	integer
total_bayar	integer
status_proses	varchar
status_bayar	varchar
catatan	text
tanggal_masuk	datetime
tanggal_ambil	datetime
created_at	timestamp
updated_at	timestamp



---

🔗 Relasi Database

Pelanggan (1) -------- (N) Transaksi

Paket Laundry (1) -------- (N) Transaksi

Artinya:

Satu pelanggan dapat memiliki banyak transaksi.

Satu paket laundry dapat digunakan pada banyak transaksi.



---

💻 Teknologi yang Digunakan

Teknologi	Kegunaan

Laravel 12	Framework Backend
PHP 8.2	Bahasa Pemrograman
MySQL	Database
Blade	Template Engine
Bootstrap	User Interface
CSS Custom	Tampilan Modern
JavaScript	Interaksi Halaman



---

🚀 Cara Menjalankan Project

1. Clone Repository

git clone https://github.com/username/laundryglow.git

2. Masuk ke Folder Project

cd laundryglow

3. Install Dependency

composer install

4. Copy File Environment

cp .env.example .env

5. Generate Key

php artisan key:generate

6. Atur Database pada File .env

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laundryglow
DB_USERNAME=root
DB_PASSWORD=

7. Jalankan Migration

php artisan migrate

8. Menjalankan Server

php artisan serve

Buka browser:

http://127.0.0.1:8000


---

📸 Tampilan Sistem

Dashboard

Menampilkan ringkasan pendapatan, jumlah pelanggan, dan transaksi terbaru.

Manajemen Pelanggan

Mengelola data pelanggan secara lengkap.

Paket Laundry

Mengelola jenis paket dan tarif laundry.

Transaksi Laundry

Mencatat seluruh transaksi dan riwayat laundry.

Detail Invoice

Menampilkan informasi detail transaksi serta status pengerjaan laundry.


---

👨‍💻 Pengembang

Nama: Claresta Aristawati

Project: LaundryGlow – Sistem Manajemen Laundry Berbasis Web

Framework: Laravel 12

Tahun Pembuatan: 2026


---

📌 Kesimpulan

LaundryGlow adalah sistem informasi laundry berbasis web yang dirancang untuk membantu proses administrasi usaha laundry secara digital. Sistem ini menyediakan fitur pengelolaan pelanggan, paket layanan, transaksi, invoice, serta monitoring status pengerjaan dan pembayaran sehingga proses bisnis laundry menjadi lebih efektif, efisien, dan terstruktur.
