<?php
try {
    $dsn = 'mysql:host=localhost;dbname=jemaat';
    $username = 'root'; // Sesuaikan dengan username database Anda
    $password = ''; // Sesuaikan dengan password database Anda
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ];

    $conn = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
