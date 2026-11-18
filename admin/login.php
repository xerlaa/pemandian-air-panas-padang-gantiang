<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../config/helpers.php';
if (!empty($_SESSION['admin_id'])) { header('Location: dashboard.php'); exit; }
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare('SELECT * FROM admin WHERE username = ? LIMIT 1');
    $stmt->execute([trim($_POST['username'] ?? '')]);
    $admin = $stmt->fetch();
    if ($admin && password_verify($_POST['password'] ?? '', $admin['password'])) {
        session_regenerate_id(true);
        $_SESSION['admin_id'] = $admin['id_admin'];
        $_SESSION['admin_nama'] = $admin['nama'];
        header('Location: dashboard.php'); exit;
    }
    $error = 'Username atau password salah.';
}
?>
<!DOCTYPE html><html lang="id"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Login Admin</title><link rel="stylesheet" href="../assets/css/style.css"></head>
<body class="login-page"><form class="login-card" method="post"><h1>Login Admin</h1><p>Panel pengelolaan wisata</p><?php if ($error): ?><p class="error"><?= e($error) ?></p><?php endif; ?><label>Username<input name="username" required></label><label>Password<input type="password" name="password" required></label><button class="button" type="submit">Masuk</button><a href="../index.php">Kembali ke website</a></form></body></html>
