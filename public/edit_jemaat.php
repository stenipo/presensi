<?php
// Sertakan koneksi database
require_once('../src/config/database.php');

// Cek apakah form telah disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $alamat = $_POST['alamat'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $sektor = $_POST['sektor'];
    $nomor_telepon = $_POST['nomor_telepon'];

    // Validasi nilai jenis_kelamin agar sesuai dengan ENUM('L', 'P')
    if (!in_array($jenis_kelamin, ['L', 'P'])) {
        // Redirect dengan pesan error jika nilai tidak valid
        header("Location: manage_jemaat.php?status=error&message=Jenis kelamin tidak valid.");
        exit();
    }

    try {
        // Query untuk memperbarui data jemaat
        $query = "UPDATE jemaat SET 
                    nama = :nama, 
                    jenis_kelamin = :jenis_kelamin,
                    alamat = :alamat, 
                    tanggal_lahir = :tanggal_lahir, 
                    sektor = :sektor, 
                    nomor_telepon = :nomor_telepon 
                  WHERE id = :id";
        
        $stmt = $conn->prepare($query);
        
        // Bind parameter
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':jenis_kelamin', $jenis_kelamin);
        $stmt->bindParam(':alamat', $alamat);
        $stmt->bindParam(':tanggal_lahir', $tanggal_lahir);
        $stmt->bindParam(':sektor', $sektor);
        $stmt->bindParam(':nomor_telepon', $nomor_telepon);

        // Eksekusi query
        if ($stmt->execute()) {
            // Redirect ke halaman manajemen jemaat dengan pesan sukses
            header("Location: manage_jemaat.php?status=success");
            exit();
        } else {
            throw new Exception("Gagal memperbarui data.");
        }
    } catch (Exception $e) {
        // Redirect ke halaman manajemen jemaat dengan pesan error
        header("Location: manage_jemaat.php?status=error&message=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Redirect ke halaman manajemen jemaat jika tidak ada form yang disubmit
    header("Location: manage_jemaat.php");
    exit();
}
?>
