<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';
admin_required();
$uploadDir = __DIR__ . '/../uploads/berita/';
if (!is_dir($uploadDir)) mkdir($uploadDir, 0775, true);
$error = '';
$edit = null;
if (isset($_GET['edit'])) {
    $stmt = $pdo->prepare('SELECT * FROM berita WHERE id_berita=?');
    $stmt->execute([(int)$_GET['edit']]);
    $edit = $stmt->fetch();
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int)($_POST['id_berita'] ?? 0);
    $judul = trim($_POST['judul'] ?? '');
    $kategori = trim($_POST['kategori'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $isi = trim($_POST['isi'] ?? '');
    $status = ($_POST['status'] ?? 'Draft') === 'Published' ? 'Published' : 'Draft';
    $gambar = $_POST['gambar_lama'] ?? '';
    if (!empty($_FILES['gambar']['name'])) {
        $ext = strtolower(pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION));
        if (!in_array($ext, ['jpg','jpeg','png','webp'])) {
            $error = 'Format gambar harus JPG, PNG, atau WEBP.';
        } elseif ($_FILES['gambar']['size'] > 2 * 1024 * 1024) {
            $error = 'Ukuran gambar maksimal 2 MB.';
        } else {
            $gambar = uniqid('berita_', true) . '.' . $ext;
            if (!move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadDir . $gambar)) {
                $error = 'Gagal mengunggah gambar.';
            }
        }
    }
    if (!$error && $judul !== '' && $penulis !== '' && $isi !== '') {
        if ($id) {
            $stmt = $pdo->prepare('UPDATE berita SET judul=?, kategori=?, penulis=?, isi=?, gambar=?, status=?, tanggal_publikasi=IF(?="Published", NOW(), NULL) WHERE id_berita=?');
            $stmt->execute([$judul,$kategori,$penulis,$isi,$gambar,$status,$status,$id]);
        } else {
            $stmt = $pdo->prepare('INSERT INTO berita (judul,kategori,penulis,isi,gambar,status,tanggal_publikasi) VALUES (?,?,?,?,?,?,IF(?="Published", NOW(), NULL))');
            $stmt->execute([$judul,$kategori,$penulis,$isi,$gambar,$status,$status]);
        }
        header('Location: berita.php?saved=1'); exit;
    }
}
if (isset($_GET['delete'])) {
    $stmt = $pdo->prepare('SELECT gambar FROM berita WHERE id_berita=?');
    $stmt->execute([(int)$_GET['delete']]);
    $old = $stmt->fetch();
    $stmt = $pdo->prepare('DELETE FROM berita WHERE id_berita=?');
    $stmt->execute([(int)$_GET['delete']]);
    if ($old && $old['gambar'] && is_file($uploadDir . $old['gambar'])) unlink($uploadDir . $old['gambar']);
    header('Location: berita.php?deleted=1'); exit;
}
$rows = $pdo->query('SELECT * FROM berita ORDER BY created_at DESC')->fetchAll();
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Kelola Berita</title><link rel="stylesheet" href="../assets/css/style.css"></head><body>
<div class="admin-layout"><aside class="admin-sidebar"><h2>NEWS ADMIN</h2><a href="dashboard.php">Dashboard</a><a class="active" href="berita.php">Data Berita</a><a href="../index.php">Lihat Website</a><a href="logout.php">Logout</a></aside>
<main class="admin-main"><div class="admin-top"><div><h1>Kelola Berita</h1><p>Tambah, edit, dan hapus artikel website.</p></div><a class="button secondary" href="dashboard.php">Dashboard</a></div>
<?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?>
<?php if (isset($_GET['saved'])): ?><p class="success">Data berita berhasil disimpan.</p><?php endif; ?>
<?php if (isset($_GET['deleted'])): ?><p class="success">Berita berhasil dihapus.</p><?php endif; ?>
<section class="panel"><h2><?= $edit ? 'Edit Berita' : 'Tambah Berita' ?></h2>
<form method="post" enctype="multipart/form-data" class="form-grid">
<input type="hidden" name="id_berita" value="<?= e($edit['id_berita'] ?? '') ?>">
<input type="hidden" name="gambar_lama" value="<?= e($edit['gambar'] ?? '') ?>">
<label>Judul Berita<input name="judul" required value="<?= e($edit['judul'] ?? '') ?>"></label>
<label>Kategori<input name="kategori" value="<?= e($edit['kategori'] ?? '') ?>" placeholder="Contoh: Wisata"></label>
<label>Penulis<input name="penulis" required value="<?= e($edit['penulis'] ?? $_SESSION['admin_nama']) ?>"></label>
<label>Status<select name="status"><option <?= (($edit['status'] ?? '')==='Draft')?'selected':'' ?>>Draft</option><option <?= (($edit['status'] ?? '')==='Published')?'selected':'' ?>>Published</option></select></label>
<label class="full">Gambar Berita<input type="file" name="gambar" accept="image/jpeg,image/png,image/webp"><small>Format JPG/PNG/WEBP, maksimal 2 MB. Kosongkan jika tidak mengganti gambar.</small></label>
<label class="full">Isi Berita<textarea name="isi" rows="7" required><?= e($edit['isi'] ?? '') ?></textarea></label>
<div class="full form-actions"><button class="button" type="submit">Simpan Berita</button><a class="button secondary" href="berita.php">Reset</a></div>
</form></section>
<section class="panel"><h2>Daftar Berita</h2><div class="table-wrap"><table><thead><tr><th>Judul</th><th>Kategori</th><th>Penulis</th><th>Status</th><th>Aksi</th></tr></thead><tbody>
<?php foreach ($rows as $r): ?><tr><td><?= e($r['judul']) ?></td><td><?= e($r['kategori']) ?></td><td><?= e($r['penulis']) ?></td><td><?= e($r['status']) ?></td><td><a href="berita.php?edit=<?= $r['id_berita'] ?>">Edit</a> | <a class="danger-link" href="berita.php?delete=<?= $r['id_berita'] ?>" onclick="return confirm('Yakin hapus berita ini?')">Hapus</a></td></tr><?php endforeach; ?>
<?php if (!$rows): ?><tr><td colspan="5">Belum ada berita.</td></tr><?php endif; ?>
</tbody></table></div></section></main></div></body></html>
