<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah 'majelis'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'majelis') {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kegiatan</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <!-- HTML5 QR Code Scanner JS -->
    <script src="js/html5-qrcode.min.js"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">HKBP Buhit</a>
        <div class="navbar-nav ml-auto">
            <a class="nav-link" href="majelis_dashboard.php">Dashboard</a>
            <a class="nav-link" href="logout.php">Logout</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Presensi Kegiatan Gereja</h2>
        <p class="text-center">Silakan scan QR Code Jemaat untuk melakukan presensi.</p>

        <div class="row">
            <div class="col-md-6 mx-auto">
                <!-- Video for QR scanning -->
                <div id="qr-reader" style="width:100%;"></div>

                <!-- Presensi buttons -->
                <button id="tutup-presensi" class="btn btn-danger btn-block mt-3">Tutup Presensi</button>
            </div>
        </div>
    </div>

    <script>
        // Inisialisasi Scanner QR Code
        const html5QrCode = new Html5Qrcode("qr-reader");

        // Fungsi untuk mulai scan QR Code
        function startScan() {
            html5QrCode.start(
                { facingMode: "environment" }, // Pilih kamera belakang (environment)
                { fps: 10, qrbox: 250 }, // Pengaturan FPS dan ukuran QR box
                qrCodeMessage => {
                    console.log("QR Code detected:", qrCodeMessage);
                    // Kirim data QR code ke server untuk proses absensi
                    alert("QR Code Terdeteksi: " + qrCodeMessage);

                    // Mengirimkan data ke server (presensi_process.php)
                    $.ajax({
    url: '../src/controllers/presensi_process.php',
    method: 'POST',
    data: { qr_code_data: qrCodeMessage },
    success: function(response) {
        console.log("Respons server:", response); // Log respons dari server
        try {
            const data = JSON.parse(response);
            alert(data.message);
        } catch (e) {
            console.error("Error parsing JSON:", e);
        }
    },
    error: function(xhr, status, error) {
        console.error("Error saat mengirim data:", error);
        console.log("Response Text:", xhr.responseText); // Log response text dari server
    }
});

                },
                errorMessage => {
                    console.error(errorMessage);
                }
            ).catch(err => {
                console.log("Error scanning:", err);
            });
        }

        // Fungsi untuk menutup presensi
        function stopScan() {
            html5QrCode.stop().then(() => {
                console.log("Scanner stopped.");
            }).catch(err => {
                console.log("Error stopping scanner:", err);
            });
        }

        // Event listener untuk tombol tutup presensi
        document.getElementById("tutup-presensi").addEventListener("click", function() {
            stopScan(); // Stop the QR scanner
            window.location.href = "majelis_dashboard.php"; // Redirect ke dashboard majelis
        });

        // Start QR scanner
        startScan();
    </script>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
