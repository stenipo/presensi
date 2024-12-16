<?php
require_once('../src/config/database.php');

// Menangani data form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = $_POST['nama'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $sektor = $_POST['sektor'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Menyimpan data ke database
    $query = "INSERT INTO jemaat (nama, alamat, tanggal_lahir, sektor, nomor_telepon) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$nama, $alamat, $tanggal_lahir, $sektor, $nomor_telepon]);

    // Redirect kembali ke halaman manage jemaat
    header("Location: manage_jemaat.php");
    exit();
}
?>
