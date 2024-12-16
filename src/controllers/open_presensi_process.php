<?php
session_start();

// Validasi CSRF Token
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        $_SESSION['message'] = "Token tidak valid!";
        $_SESSION['message_type'] = "danger";
        header("Location: ../../public/open_presensi.php");
        exit();
    }

    // Ambil input dan validasi
    $nama_kegiatan = filter_input(INPUT_POST, 'nama_kegiatan', FILTER_SANITIZE_STRING);
    $tanggal_kegiatan = filter_input(INPUT_POST, 'tanggal_kegiatan', FILTER_SANITIZE_STRING);
    $deskripsi = filter_input(INPUT_POST, 'deskripsi', FILTER_SANITIZE_STRING);

    if ($nama_kegiatan && $tanggal_kegiatan && $deskripsi) {
        // Simpan ke database (contoh query)
        require '../config/database.php';
        $query = $conn->prepare("INSERT INTO kegiatan (nama_kegiatan, tanggal_kegiatan, deskripsi) VALUES (?, ?, ?)");
        if ($query->execute([$nama_kegiatan, $tanggal_kegiatan, $deskripsi])) {
            $_SESSION['message'] = "Portal presensi berhasil dibuka!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Terjadi kesalahan saat membuka portal presensi.";
            $_SESSION['message_type'] = "danger";
        }
    } else {
        $_SESSION['message'] = "Semua field harus diisi!";
        $_SESSION['message_type'] = "warning";
    }

    header("Location: ../../public/open_presensi.php");
    exit();
}
?>
