<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah 'pendeta'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'pendeta') {
    header("Location: login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pendeta</title>
    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="images/hkbp-logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
            HKBP Buhit
        </a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Selamat Datang, Pendeta!</h2>
        <p class="text-center">Simulasi Pencatatan dan Pengelolaan Data Kehadiran Jemaat HKBP Buhit</p>
        <hr>
        <div class="row">
            <!-- Card: Laporan Kegiatan -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Laporan Kegiatan</h5>
                        <p class="card-text">Lihat laporan kehadiran jemaat berdasarkan kegiatan gereja.</p>
                        <a href="laporan_kegiatan.php" class="btn btn-primary">Lihat Laporan</a>
                    </div>
                </div>
            </div>
            <!-- Card: Manajemen Akun -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Manajemen Akun</h5>
                        <p class="card-text">Kelola informasi akun Anda seperti nama, email, dan password.</p>
                        <a href="manajemen_akun.php" class="btn btn-warning">Kelola Akun</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-5">
        <p>&copy; 2024 HKBP Buhit - Simulasi Pencatatan Kehadiran Jemaat</p>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
