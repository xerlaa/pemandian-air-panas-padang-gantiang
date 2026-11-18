<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/helpers.php';
$profil = $pdo->query('SELECT * FROM profil_wisata ORDER BY id ASC LIMIT 1')->fetch();
$fasilitas = $pdo->query('SELECT * FROM fasilitas ORDER BY id_fasilitas DESC')->fetchAll();
$galeri = $pdo->query('SELECT * FROM galeri ORDER BY tanggal_upload DESC LIMIT 6')->fetchAll();
$berita = $pdo->query("SELECT * FROM berita WHERE status='Published' ORDER BY created_at DESC LIMIT 6")->fetchAll();
$kontak = $pdo->query('SELECT * FROM kontak ORDER BY id_kontak ASC LIMIT 1')->fetch();
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($profil['nama_wisata'] ?? 'Pemandian Air Panas') ?></title>
<link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header class="site-header"><a class="brand" href="index.php">Padang Gantiang Tourism</a>
<nav><a href="#tentang">Tentang</a><a href="#fasilitas">Fasilitas</a><a href="#galeri">Galeri</a><a href="#berita">Berita</a><a href="#lokasi">Lokasi</a></nav></header>
<main>
<section class="hero"><div><p class="eyebrow">Wisata Alam Padang Gantiang</p>
<h1><?= e($profil['nama_wisata'] ?? 'Pemandian Air Panas Padang Gantiang') ?></h1>
<h2><?= e($profil['slogan'] ?? 'Wisata Alam dan Relaksasi') ?></h2>
<p><?= e($profil['deskripsi'] ?? '') ?></p><a class="button" href="#tentang">Jelajahi Wisata</a></div>
<div class="hero-image"><?php if (!empty($profil['gambar_utama'])): ?><img src="uploads/profil/<?= e($profil['gambar_utama']) ?>" alt="Pemandian air panas"><?php else: ?><div class="image-placeholder">Foto utama wisata</div><?php endif; ?></div></section>
<section id="tentang" class="section two-col"><div><p class="eyebrow">Tentang Kami</p><h2>Sejarah Pemandian Air Panas</h2><p><?= nl2br(e($profil['sejarah'] ?? 'Informasi sejarah wisata dapat ditambahkan oleh admin.')) ?></p></div><aside class="info-box"><h3>Selamat Datang</h3><p>Temukan informasi wisata, fasilitas, galeri, dan berita terbaru di sini.</p></aside></section>
<section id="fasilitas" class="section"><p class="eyebrow">Untuk Pengunjung</p><h2>Fasilitas &amp; Kenyamanan</h2><div class="cards"><?php foreach ($fasilitas as $f): ?><article class="card"><?php if ($f['gambar']): ?><img src="uploads/fasilitas/<?= e($f['gambar']) ?>" alt=""><?php endif; ?><h3><?= e($f['nama_fasilitas']) ?></h3><p><?= e($f['deskripsi']) ?></p></article><?php endforeach; ?></div></section>
<section id="galeri" class="section"><p class="eyebrow">Dokumentasi</p><h2>Keindahan Alam &amp; Suasana</h2><div class="gallery"><?php foreach ($galeri as $g): ?><figure><img src="uploads/galeri/<?= e($g['foto']) ?>" alt="<?= e($g['judul']) ?>"><figcaption><?= e($g['judul']) ?></figcaption></figure><?php endforeach; ?><?php if (!$galeri): ?><p>Foto galeri belum tersedia.</p><?php endif; ?></div></section>
<section id="berita" class="section"><p class="eyebrow">Informasi Terbaru</p><h2>Berita &amp; Artikel</h2><div class="cards"><?php foreach ($berita as $b): ?><article class="card"><?php if ($b['gambar']): ?><img src="uploads/berita/<?= e($b['gambar']) ?>" alt=""><?php endif; ?><small><?= e($b['kategori']) ?> · <?= e($b['penulis']) ?></small><h3><?= e($b['judul']) ?></h3><p><?= e(mb_substr(strip_tags($b['isi']), 0, 150)) ?>...</p></article><?php endforeach; ?><?php if (!$berita): ?><p>Belum ada berita yang dipublikasikan.</p><?php endif; ?></div></section>
<section id="lokasi" class="section two-col"><div><p class="eyebrow">Kunjungi Kami</p><h2>Lokasi &amp; Informasi</h2><p><?= e($kontak['alamat'] ?? 'Padang Gantiang, Sumatera Barat') ?></p><p>Telepon: <?= e($kontak['telepon'] ?? '-') ?></p><p>Email: <?= e($kontak['email'] ?? '-') ?></p><p>Jam: <?= e($kontak['jam_operasional'] ?? '-') ?></p></div><div class="map-placeholder">Tambahkan tautan Google Maps melalui data pengelola.</div></section>
</main>
<footer><h3>Padang Gantiang Tourism</h3><p>Informasi wisata Pemandian Air Panas Padang Gantiang.</p><p>&copy; <?= date('Y') ?> Padang Gantiang Tourism</p></footer>
</body></html>
