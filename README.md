# TP8DPBO2526C2
TUGAS PRAKTIKUM 8 DPBO ARSITEKTUR MVC DALAM WEB (PHP & MySQL) Renaldy Heryana (2509867) Ilmu Komputer C2 Universitas Pendidikan Indonesia

# janji
Saya Renaldy Heryana dengan NIM 2509867 mengerjakan TP8 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek untuk keberkahanNya maka saya tidak melakukan kecurangan seperti yang telah dispesifikasikan. Aamiin.

# TEMA WEBSITE

Website ini bernama **Lecturer Management System**, yaitu sistem pengelolaan data dosen dan program studi (prodi) di lingkungan kampus. Website digunakan untuk mengelola dua data utama, yaitu dosen dan prodi. Setiap prodi dipimpin oleh satu dosen sebagai kepala prodi (kaprodi), dan satu dosen dapat menjadi kaprodi di lebih dari satu prodi. Semua data dapat ditambah, dilihat, diubah, dan dihapus (CRUD) langsung dari browser.

Program dibangun dengan arsitektur MVC (Model, View, Controller) menggunakan PHP berorientasi objek.

# ARSITEKTUR MVC

- Model, adalah class di folder `models` yang berhubungan langsung dengan database. Model hanya menjalankan query dan tidak berisi HTML maupun pengolahan request
- View, adalah file di folder `views` dan `templates` yang hanya menampilkan data dari controller dalam bentuk HTML
- Controller, adalah class di folder `controllers` yang menerima request, memvalidasi input, memanggil model, lalu memilih view yang ditampilkan
- Router, adalah `index.php` yang membaca parameter `page` dan `action` pada URL, lalu memanggil method controller yang sesuai

# DATABASE

Nama database: `tp_mvc25` (MySQL/MariaDB). Akses database memakai mysqli.

## TABEL

### Tabel `lecturers`
Menyimpan data dosen.

- nidn, adalah primary key berupa NIDN dosen
- name, adalah nama dosen
- phone, adalah nomor telepon dosen
- join_date, adalah tanggal dosen mulai bergabung (format tahun-bulan-tanggal)

### Tabel `departments`
Menyimpan data prodi beserta kaprodinya.

- id, adalah primary key berupa kode prodi
- name, adalah nama prodi
- head_department_nidn, adalah NIDN dosen yang menjadi kaprodi, wajib diisi. Merupakan foreign key ke `lecturers.nidn` (constraint `fk_departments_lecturer`)

## RELASI ANTAR TABEL

- `lecturers` dan `departments` berhubungan one-to-many. Satu dosen dapat menjadi kaprodi di banyak prodi, sedangkan satu prodi hanya memiliki satu kaprodi
- NIDN kaprodi harus sudah ada di tabel `lecturers`
- Dosen yang masih menjadi kaprodi tidak dapat dihapus karena terikat foreign key. Kaprodi pada prodi tersebut harus diganti atau prodinya dihapus lebih dulu

File SQL hasil export database ada di folder `Database`.

# STRUKTUR REPO

```
TP8DPBO2526C2
├── Database
│   └── tp_mvc25.sql
├── Dokumentasi
│   └── Screencast From 2026-11-20 15-56-36.webm
├── Project
│   ├── assets
│   │   ├── bootstrap.bundle.min.js
│   │   ├── bootstrap.min.css
│   │   ├── bootstrap.min.js
│   │   ├── jquery.min.js
│   │   └── popper.min.js
│   ├── controllers
│   │   ├── DepartmentsController.php
│   │   └── LecturersController.php
│   ├── models
│   │   ├── Database.php
│   │   ├── Departments.php
│   │   └── Lecturers.php
│   ├── templates
│   │   ├── footer.php
│   │   └── header.php
│   ├── views
│   │   ├── departments
│   │   │   ├── createDepartment.php
│   │   │   ├── editDepartment.php
│   │   │   └── indexDepartment.php
│   │   └── lecturers
│   │       ├── createLecturer.php
│   │       ├── editLecturer.php
│   │       └── indexLecturer.php
│   ├── Config.php
│   └── index.php
└── README.md
```

# ALUR PROGRAM

1. Program dimulai dari `index.php`. File ini memuat `Config.php`, kedua model, dan kedua controller, lalu membaca parameter `page` (`?page=lecturers` atau `?page=departments`) dan `action` (`index`, `create`, `edit`, atau `delete`) pada URL.
2. Nilai `page` dan `action` dicek terhadap daftar yang diizinkan. Nilai yang tidak dikenal diganti nilai bawaan (`lecturers` dan `index`), karena nilai `action` dipakai untuk memanggil method controller secara dinamis.
3. `index.php` memilih controller sesuai `page`. Untuk `departments`, dibuat model `Departments` dan model `Lecturers` (daftar dosen dipakai untuk pilihan kaprodi) lalu `DepartmentsController`. Selain itu dibuat model `Lecturers` dan `LecturersController`. Setiap model memanggil `open()` untuk membuka koneksi, lalu method controller sesuai `action` dipanggil.
4. Controller memuat view dengan `require`, sehingga variabel milik method controller (seperti `$lecturers`, `$department`, dan `$error`) langsung dapat dipakai di view. Setiap view memuat `header.php` di bagian atas dan `footer.php` di bagian bawah.
5. **Read**: `index()` memanggil method model untuk mengambil semua data, lalu view menampilkannya dalam tabel. Jika tabel kosong, tampil pesan bahwa data belum ada.
6. **Create**: tombol "Add New" membuka form. Saat form dikirim lewat `POST`, controller membaca isian, memvalidasi bahwa semua field terisi, memanggil method `create` model, lalu mengarahkan ke halaman daftar. Jika ada error, form tampil lagi dengan isian sebelumnya dan pesan error.
7. **Update**: tombol "Edit" membawa kunci data (NIDN untuk dosen, id untuk prodi) pada URL. Controller mengambil data lama dan mengisi form. Kunci data pada form bersifat `readonly` karena merupakan primary key. Saat form dikirim, controller memanggil method `update` lalu mengarahkan ke halaman daftar.
8. **Delete**: tombol "Delete" adalah form `POST`. Controller memeriksa bahwa datanya ada, lalu memanggil method `delete`. Penghapusan hanya diterima lewat `POST`, sehingga tidak bisa dipicu hanya dengan membuka alamat URL.
9. **Pilih kaprodi**: pada form tambah dan ubah prodi, kaprodi dipilih lewat dropdown yang berisi dosen yang sudah ada, sehingga NIDN tidak perlu diketik manual.
10. Program berjalan selama server PHP aktif.

# CARA MENJALANKAN

1. Buat database `tp_mvc25` lalu import file `.sql` dari folder `Database`:
   ```bash
   mysql -u root -p -e "CREATE DATABASE IF NOT EXISTS tp_mvc25"
   mysql -u root -p tp_mvc25 < Database/tp_mvc25.sql
   ```
   File ini diexport dari MariaDB 11.8. Jika import gagal karena collation `utf8mb4_uca1400_ai_ci` tidak dikenal (versi MySQL/MariaDB yang lebih lama), ganti collation tersebut dengan `utf8mb4_general_ci` pada file SQL.
2. Sesuaikan host, user, password, dan nama database pada `Project/Config.php`. Bawaannya `localhost`, user `root`, tanpa password.
3. Jalankan server PHP dari folder `Project`:
   ```bash
   cd Project
   php -S localhost:8000
   ```
   Jika memakai XAMPP atau Laragon, letakkan folder `Project` di `htdocs` atau `www`, lalu buka lewat alamat `http://localhost/Project/index.php`.
4. Buka `http://localhost:8000/index.php?page=lecturers` di browser.

Program memerlukan PHP 8.1 atau lebih baru dengan ekstensi mysqli.

# ERROR HANDLING

1. Semua query yang menerima input memakai prepared statement (`executePrepared`) agar input user tidak bisa menyisipkan SQL.
2. Controller memvalidasi di sisi server bahwa semua field terisi sebelum memanggil model. Pesan "Semua field wajib diisi." ditampilkan di form jika ada yang kosong.
3. NIDN yang sudah terdaftar ditolak saat menambah dosen. Controller menangkap `mysqli_sql_exception` dengan kode 1062 (data ganda) dan menampilkan pesan "NIDN sudah terdaftar.". Error dengan kode lain dilempar ulang agar tidak hilang diam-diam.
4. Dosen yang masih menjadi kaprodi ditolak penghapusannya oleh foreign key. Controller menangkap error kode 1451 pada `delete` dan menampilkan pesan peringatan di halaman daftar dosen.
5. Penghapusan hanya diterima lewat `POST`. Request `GET` ke aksi hapus langsung diarahkan kembali ke halaman daftar.
6. Pada `edit` dan `delete`, controller memeriksa lebih dulu bahwa datanya ada (`getByNidn` atau `getById`). Hal ini diperlukan karena method `update` dan `delete` di model tetap berhasil dijalankan walau datanya tidak ditemukan. Jika data tidak ada, pengguna diarahkan ke halaman daftar.
7. Kunci data pada form edit (NIDN dan id prodi) bersifat `readonly`, dan nilainya diambil dari URL, bukan dari form.
8. Semua data yang ditampilkan di view dibungkus `htmlspecialchars` untuk mencegah XSS.
9. Parameter `page` dan `action` di URL dicek terhadap daftar yang diizinkan sebelum dipakai.
10. Query yang gagal dilaporkan lewat `RuntimeException`, dan koneksi `mysqli` pada PHP 8.1 ke atas otomatis melempar `mysqli_sql_exception`, sehingga tidak ada kegagalan yang diam-diam.
11. Tabel yang kosong tetap tampil dengan pesan "Belum ada data".

# PENJELASAN ATRIBUT DAN METHOD

## FILE index.php (router)

- DEFAULT_ACTION, adalah konstanta aksi bawaan, yaitu `index`
- ALLOWED_ACTIONS, adalah daftar aksi yang diizinkan, yaitu `index`, `create`, `edit`, dan `delete`
- DEFAULT_PAGE, adalah konstanta halaman bawaan, yaitu `lecturers`
- ALLOWED_PAGE, adalah daftar halaman yang diizinkan, yaitu `lecturers` dan `departments`
- DEPARTMENT_PAGE, adalah konstanta untuk nilai halaman `departments`, dipakai untuk memilih controller

## FILE Config.php

- db_host, adalah alamat server database
- db_user, adalah nama user database
- db_pass, adalah password user database
- db_name, adalah nama database yang dipakai

## CLASS Database

Mengelola koneksi dan eksekusi query. Class `Lecturers` dan `Departments` mewarisi class ini.

### Atribut
- db_host, db_user, db_password, db_name, adalah atribut protected berisi data koneksi
- db_link, adalah atribut protected berisi koneksi mysqli yang sedang terbuka
- result, adalah atribut protected berisi hasil query terakhir

### Method
- constructor, adalah method untuk menyimpan host, user, password, dan nama database ke atribut
- open, adalah method untuk membuka koneksi ke database
- execute, adalah method untuk menjalankan query biasa tanpa parameter dan menyimpan hasilnya
- executePrepared, adalah method untuk menjalankan query dengan prepared statement. Tipe parameter ditulis dengan huruf (`s` untuk string), hasil SELECT disimpan agar bisa dibaca, dan nilai kembaliannya `true` jika query berhasil dijalankan
- getResult, adalah method untuk mengambil satu baris dari hasil query terakhir
- close, adalah method untuk menutup koneksi

## CLASS Lecturers

Mengelola tabel `lecturers`.

- getLecturers, adalah method untuk mengambil seluruh dosen
- getByNidn, adalah method untuk mengambil satu dosen berdasarkan NIDN, mengembalikan `null` jika tidak ditemukan
- create, adalah method untuk menambah dosen baru (nidn, name, phone, join_date)
- update, adalah method untuk mengubah nama, telepon, dan tanggal bergabung dosen berdasarkan NIDN
- delete, adalah method untuk menghapus dosen berdasarkan NIDN

## CLASS Departments

Mengelola tabel `departments`.

- getDepartment, adalah method untuk mengambil seluruh prodi
- getById, adalah method untuk mengambil satu prodi berdasarkan id, mengembalikan `null` jika tidak ditemukan
- create, adalah method untuk menambah prodi baru (id, name, head_department_nidn)
- update, adalah method untuk mengubah nama dan kaprodi berdasarkan id
- delete, adalah method untuk menghapus prodi berdasarkan id

## CLASS LecturersController

Menghubungkan model `Lecturers` dengan view dosen.

### Atribut dan konstanta
- model, adalah atribut private berisi objek `Lecturers`
- MYSQL_DUPLICATE_KEY, adalah konstanta kode error MySQL untuk data ganda (1062)
- MYSQL_ERROR_FOREIGN, adalah konstanta kode error MySQL untuk data yang masih dipakai foreign key (1451)
- INDEX_URL, adalah alamat halaman daftar dosen untuk redirect
- VIEW_DIR, adalah lokasi folder view dosen
- ERROR_EMPTY dan ERROR_DUPLICATE, adalah konstanta pesan error

### Method
- constructor, adalah method untuk menyimpan model ke atribut
- index, adalah method untuk menampilkan semua dosen. Menerima pesan error opsional untuk ditampilkan di atas tabel
- create, adalah method untuk menampilkan form tambah dosen dan memproses pengirimannya
- edit, adalah method untuk menampilkan form ubah dosen dan memproses pengirimannya
- delete, adalah method untuk menghapus dosen. Hanya menerima `POST` dan menangani penolakan oleh foreign key
- readForm, adalah method private untuk membaca dan merapikan isian form
- validate, adalah method private untuk memastikan tidak ada field yang kosong
- saveNew, adalah method private untuk menyimpan dosen baru dan menerjemahkan error data ganda menjadi pesan
- redirectToIndex, adalah method private untuk mengarahkan ke halaman daftar lalu menghentikan program

## CLASS DepartmentsController

Menghubungkan model `Departments` dan `Lecturers` dengan view prodi.

### Atribut dan konstanta
- modelDepartment, adalah atribut private berisi objek `Departments`
- modelLecturer, adalah atribut private berisi objek `Lecturers`, dipakai untuk mengisi pilihan kaprodi
- MYSQL_DUPLICATE_KEY, INDEX_URL, VIEW_DIR, ERROR_EMPTY, dan ERROR_DUPLICATE, adalah konstanta dengan fungsi yang sama seperti di `LecturersController`

### Method
- constructor, adalah method untuk menyimpan kedua model ke atribut
- index, adalah method untuk menampilkan semua prodi
- create, adalah method untuk menampilkan form tambah prodi (lengkap dengan daftar dosen untuk dropdown kaprodi) dan memproses pengirimannya
- edit, adalah method untuk menampilkan form ubah prodi dan memproses pengirimannya
- delete, adalah method untuk menghapus prodi. Hanya menerima `POST` dan memeriksa dulu bahwa prodinya ada
- readForm, validate, saveNew, dan redirectToIndex, adalah method private dengan fungsi yang sama seperti di `LecturersController`

## FILE TEMPLATE

- header.php, adalah bagian atas halaman berisi `<head>` dan navbar (Home, Lecturers, Departments). Judul tab diambil dari variabel `$title` yang diisi tiap view
- footer.php, adalah bagian bawah halaman berisi script jQuery, Popper, dan Bootstrap serta penutup HTML

## FILE VIEW

- indexLecturer.php, adalah halaman daftar dosen berisi tombol Add New, tabel, tombol Edit dan Delete, serta kotak pesan error
- createLecturer.php, adalah form tambah dosen
- editLecturer.php, adalah form ubah dosen dengan field NIDN `readonly`
- indexDepartment.php, adalah halaman daftar prodi berisi tombol Add New, tabel, serta tombol Edit dan Delete
- createDepartment.php, adalah form tambah prodi dengan dropdown kaprodi
- editDepartment.php, adalah form ubah prodi dengan field id `readonly` dan dropdown kaprodi

# DOKUMENTASI

Dokumentasi berupa screen record yang mencoba CRUD pada tabel dosen dan prodi, termasuk penolakan penghapusan dosen yang masih menjadi kaprodi. Video disimpan di folder `Dokumentasi` dengan nama file `Screencast From 2026-11-20 15-56-36.webm`.

https://github.com/user-attachments/assets/c4d5129c-f334-4035-9bb6-3f107ee91f82
