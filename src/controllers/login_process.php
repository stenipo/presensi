<?php
session_start();

// Sertakan file konfigurasi database
require_once('../config/database.php');

// Memastikan koneksi tersedia
if (!$conn) {
    die("Koneksi database gagal.");
}

// Mendapatkan data dari form login
$username = $_POST['username'];
$password = $_POST['password'];

try {
    // Menyiapkan query untuk mengecek username
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Verifikasi password
        if (password_verify($password, $user['password'])) {
            // Jika password cocok, set session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            // Redirect ke dashboard sesuai role
            if ($user['role'] == 'majelis') {
                header("Location: /hkbp/public/majelis_dashboard.php");
            } elseif ($user['role'] == 'pendeta') {
                header("Location: /hkbp/public/pendeta_dashboard.php");
            }
            exit();
        } else {
            // Password salah
            echo "Invalid login credentials.";
        }
    } else {
        // Username tidak ditemukan
        echo "Invalid login credentials.";
    }
} catch (PDOException $e) {
    // Tangani error PDO
    die("Error: " . $e->getMessage());
}
?>
