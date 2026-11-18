CREATE DATABASE IF NOT EXISTS db_pemandian
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_pemandian;

CREATE TABLE IF NOT EXISTS admin (
  id_admin INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100) NOT NULL,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS profil_wisata (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama_wisata VARCHAR(150) NOT NULL,
  slogan VARCHAR(255),
  deskripsi TEXT,
  sejarah TEXT,
  gambar_utama VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS fasilitas (
  id_fasilitas INT AUTO_INCREMENT PRIMARY KEY,
  nama_fasilitas VARCHAR(100) NOT NULL,
  deskripsi TEXT,
  gambar VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS galeri (
  id_galeri INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(150),
  keterangan TEXT,
  foto VARCHAR(255),
  tanggal_upload TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS berita (
  id_berita INT AUTO_INCREMENT PRIMARY KEY,
  judul VARCHAR(200) NOT NULL,
  kategori VARCHAR(100),
  penulis VARCHAR(100),
  isi TEXT,
  gambar VARCHAR(255),
  status ENUM('Draft','Published') DEFAULT 'Draft',
  tanggal_publikasi DATETIME NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS kontak (
  id_kontak INT AUTO_INCREMENT PRIMARY KEY,
  alamat TEXT,
  telepon VARCHAR(30),
  email VARCHAR(100),
  instagram VARCHAR(100),
  jam_operasional VARCHAR(100),
  lokasi_maps TEXT
);

INSERT INTO profil_wisata (nama_wisata, slogan, deskripsi, sejarah, gambar_utama)
SELECT 'Pemandian Air Panas Padang Gantiang',
       'Wisata Alam dan Relaksasi',
       'Nikmati suasana alam dan pengalaman berendam di pemandian air panas Padang Gantiang.',
       'Informasi sejarah wisata dapat dilengkapi oleh pengelola.',
       ''
WHERE NOT EXISTS (SELECT 1 FROM profil_wisata);

INSERT INTO fasilitas (nama_fasilitas, deskripsi)
SELECT 'Kolam Air Panas', 'Area pemandian air panas untuk pengunjung.'
WHERE NOT EXISTS (SELECT 1 FROM fasilitas);

INSERT INTO fasilitas (nama_fasilitas, deskripsi)
SELECT 'Area Parkir', 'Area parkir kendaraan pengunjung.'
WHERE NOT EXISTS (SELECT 1 FROM fasilitas);

INSERT INTO kontak (alamat, jam_operasional)
SELECT 'Padang Gantiang, Sumatera Barat', 'Hubungi pengelola untuk informasi jam operasional.'
WHERE NOT EXISTS (SELECT 1 FROM kontak);
