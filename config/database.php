<?php
$host = 'localhost';
$dbname = 'db_pemandian';
$username = 'root';
$password = ''; // Isi jika MySQL Anda memakai password

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8mb4",
        $username,
        $password,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    exit('Koneksi database gagal. Periksa config/database.php dan pastikan MySQL aktif.');
}
