<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';
admin_required();
$total = (int)$pdo->query('SELECT COUNT(*) FROM berita')->fetchColumn();
$published = (int)$pdo->query("SELECT COUNT(*) FROM berita WHERE status='Published'")->fetchColumn();
$draft = (int)$pdo->query("SELECT COUNT(*) FROM berita WHERE status='Draft'")->fetchColumn();
$rows = $pdo->query('SELECT * FROM berita ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Dashboard Admin</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<div class="admin-layout"><aside class="admin-sidebar"><h2>NEWS ADMIN</h2><a class="active" href="dashboard.php">Dashboard</a><a href="berita.php">Data Berita</a><a href="../index.php">Lihat Website</a><a href="logout.php">Logout</a></aside>
<main class="admin-main"><div class="admin-top"><div><h1>Dashboard</h1><p>Halo, <?= e($_SESSION['admin_nama']) ?>. Selamat bekerja.</p></div><a class="button" href="berita.php">+ Tambah Berita</a></div>
<div class="stats"><div class="stat"><span>Total Berita</span><strong><?= $total ?></strong></div><div class="stat"><span>Published</span><strong><?= $published ?></strong></div><div class="stat"><span>Draft</span><strong><?= $draft ?></strong></div></div>
<section class="panel"><h2>Berita Terbaru</h2><div class="table-wrap"><table><thead><tr><th>Judul</th><th>Kategori</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><td><?= e($r['judul']) ?></td><td><?= e($r['kategori']) ?></td><td><?= e($r['status']) ?></td><td><a href="berita.php?edit=<?= $r['id_berita'] ?>">Edit</a></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="4">Belum ada berita.</td></tr><?php endif; ?>
</tbody></table></div></section></main></div></body></html>
