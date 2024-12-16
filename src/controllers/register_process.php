<?php
require_once '../config/database.php';  // Pastikan path ke file database sudah benar

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mengambil data dari form
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];  // Menambahkan jenis kelamin
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $sektor = $_POST['sektor'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Memasukkan data ke dalam tabel jemaat
    try {
        $query = $conn->prepare("INSERT INTO jemaat (nama, jenis_kelamin, alamat, tanggal_lahir, sektor, nomor_telepon) VALUES (?, ?, ?, ?, ?, ?)");
        $query->execute([$nama, $jenis_kelamin, $alamat, $tanggal_lahir, $sektor, $nomor_telepon]);

        // Redirect kembali ke form dengan parameter success
        header('Location: ../../public/register.php?success=1');
        exit();
    } catch (PDOException $e) {
        // Menangani error jika ada masalah dengan query
        echo "Error: " . $e->getMessage();
    }
}
?>
