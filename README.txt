PROYEK WEBSITE PEMANDIAN AIR PANAS PADANG GANTIANG
===================================================

PERSYARATAN
- XAMPP (Apache dan MySQL)
- Visual Studio Code
- Browser

CARA MENJALANKAN
1. Ekstrak folder pemandian-air-panas ke:
   C:\xampp\htdocs\
2. Buka XAMPP, jalankan Apache dan MySQL.
3. Buka http://localhost/phpmyadmin
4. Pilih menu Import, pilih file database.sql dari folder proyek, lalu klik Import.
5. Buka http://localhost/pemandian-air-panas/setup_admin.php
6. Installer akan membuat akun admin awal. Catat username dan password yang ditampilkan.
7. Setelah berhasil, HAPUS file setup_admin.php dari folder proyek.
8. Buka halaman pengunjung:
   http://localhost/pemandian-air-panas/
9. Buka halaman admin:
   http://localhost/pemandian-air-panas/admin/login.php

CATATAN
- Koneksi database default XAMPP: host localhost, user root, password kosong.
- Jika MySQL Anda memakai password, ubah file config/database.php.
- Fitur admin yang sudah aktif pada starter ini: login, dashboard, tambah berita,
  edit berita, hapus berita, dan status Draft/Published.
- Halaman pengunjung menampilkan profil, fasilitas, galeri, dan berita dari database.
- Upload gambar berita disimpan di folder uploads/berita.
- Untuk keamanan, jangan gunakan kredensial default pada website produksi.
