<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah 'majelis'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'majelis') {
    header("Location: login.php");
    exit();
}

// Token CSRF untuk keamanan
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Presensi - Majelis</title>
    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">
            <img src="images/hkbp-logo.png" width="30" height="30" class="d-inline-block align-top" alt="Logo HKBP">
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

    <!-- Kontainer Form -->
    <div class="container mt-5">
        <h2 class="text-center">Buka Portal Presensi</h2>
        
        <!-- Pesan Feedback -->
        <?php if (isset($_SESSION['message'])): ?>
            <div class="alert alert-<?= $_SESSION['message_type']; ?> text-center">
                <?= $_SESSION['message']; ?>
            </div>
            <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
        <?php endif; ?>

        <!-- Form Pembukaan Presensi -->
        <form action="../src/controllers/open_presensi_process.php" method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">

            <div class="form-group">
                <label for="nama_kegiatan">Nama Kegiatan</label>
                <input type="text" class="form-control" id="nama_kegiatan" name="nama_kegiatan" 
                       required maxlength="100" placeholder="Masukkan nama kegiatan">
            </div>
            <div class="form-group">
                <label for="tanggal_kegiatan">Tanggal Kegiatan</label>
                <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" required>
            </div>
            <div class="form-group">
                <label for="deskripsi">Deskripsi Kegiatan</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3" 
                          required maxlength="255" placeholder="Masukkan deskripsi kegiatan"></textarea>
            </div>
            <button type="submit" class="btn btn-success btn-block">Buka Presensi</button>
        </form>
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
