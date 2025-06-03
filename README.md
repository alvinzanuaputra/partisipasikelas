# Aplikasi Partisipasi Kelas

## Pendahuluan
Aplikasi Partisipasi Kelas ini dirancang untuk mempermudah pencatatan dan pelacakan partisipasi siswa di kelas. Aplikasi ini memungkinkan pengajar atau penilai lain untuk memberikan penilaian partisipasi, kualitas berbicara, dan tingkat keterlibatan siswa. Siswa juga dapat melihat riwayat penilaian mereka, sementara administrator dapat memantau statistik dan penilaian terbaru.

## Teknologi yang Digunakan
Website ini dibangun dengan bahasa pemrograman **PHP** untuk bagian fungsionalitas server (backend) dan manajemen database. Untuk tampilan sisi depan (frontend) yang interaktif dan menarik, saya menggunakan kombinasi **HTML** dan **CSS**. Database yang digunakan adalah **MySQL**, yang berfungsi sebagai tempat penyimpanan semua data terkait siswa, kelas, penilai, dan catatan partisipasi.

### Struktur Proyek:
- [`index.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/index.php): Halaman utama aplikasi yang menyediakan portal untuk siswa, penilai, dan admin.
- [`database.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/database.php): Halaman untuk melihat data dari setiap tabel di database.
- [`api.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/api.php): Berisi semua endpoint API yang menangani permintaan data dan logika bisnis dari frontend.
- [`config.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/config.php): Berisi konfigurasi koneksi ke database MySQL.
- [`partisipasi_kelas.sql`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/partisipasi_kelas.sql): Skrip SQL untuk membuat struktur database dan mengisi data awal.

## Fitur Utama:
- **Portal Siswa**: Siswa dapat memasukkan ID mereka dan kode kelas untuk melihat skor partisipasi dan umpan balik yang telah diberikan.
- **Portal Penilai**: Penilai dapat memberikan penilaian untuk partisipasi siswa, kualitas berbicara, dan tingkat keterlibatan, serta menambahkan umpan balik tertulis.
- **Panel Admin**: Administrator dapat melihat statistik keseluruhan aplikasi, seperti total siswa, kelas, dan penilaian, serta daftar penilaian terbaru.
- **Manajemen Database**: Halaman terpisah untuk melihat semua data yang tersimpan di database (siswa, kelas, pendaftaran, penilai, partisipasi).

Dengan kombinasi PHP, HTML, CSS, dan MySQL, aplikasi ini menyediakan solusi yang lengkap dan mudah digunakan untuk mengelola partisipasi kelas.

## Ringkasan Kode Singkat File-File Penting:

- [`index.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/index.php): Ini adalah antarmuka utama aplikasi (frontend) yang berisi struktur HTML, CSS untuk styling, dan JavaScript untuk menangani interaksi pengguna dan panggilan API. Ini memiliki tiga tab utama: Portal Siswa, Portal Penilai, dan Admin.
  
- [`database.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/database.php): File ini digunakan untuk menampilkan data dari berbagai tabel database (students, classes, enrollments, assessors, participations) dalam format tabel HTML. Ini menggunakan PHP untuk mengambil data langsung dari database dan menampilkannya.
  
- [`config.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/config.php): Berisi konfigurasi koneksi database MySQL, seperti hostname, port, nama database, username, dan password. Ini juga mendefinisikan fungsi `getConnection()` dan `closeConnection()` untuk mengelola koneksi database.
  
- [`api.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/api.php): File ini adalah inti dari sisi server (backend) aplikasi. Ini berisi berbagai fungsi PHP yang bertindak sebagai endpoint API. Fungsi-fungsi ini menangani permintaan dari frontend, seperti mendapatkan daftar kelas, mendapatkan hasil siswa, menyimpan penilaian, dan mendapatkan statistik admin. Ini berinteraksi langsung dengan database melalui `config.php`.
  
- [`partisipasi_kelas.sql`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/partisipasi_kelas.sql): Ini adalah skrip SQL yang digunakan untuk membuat struktur database `partisipasi_kelas` dan mengisi data awal ke dalam tabel-tabel seperti `students`, `classes`, `assessors`, `enrollments`, dan `participations`. Ini mendefikasikan skema tabel dan data sampel.

Secara keseluruhan, [`index.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/index.php), [`database.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/database.php) dan file HTML/CSS/JS lainnya membentuk tampilan depan, [`api.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/api.php) dan [`config.php`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/config.php) menangani logika server dan koneksi database, dan [`partisipasi_kelas.sql`](https://github.com/alvinzanuaputra/partisipasikelas/blob/main/partisipasi_kelas.sql) adalah untuk setup database.

