<?php
// Debugging - Periksa data POST yang dikirim
file_put_contents('debug_log.txt', print_r($_POST, true), FILE_APPEND);

// Aktifkan error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set header untuk respons JSON
header('Content-Type: application/json');

// Ambil data dari AJAX
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $qr_code_data = $_POST['qr_code_data'] ?? '';

    // Validasi data QR Code
    if (!empty($qr_code_data)) {
        // Proses data QR Code - Simpan presensi di database
        // Contoh: Jika QR Code berisi ID jemaat, proses ID tersebut untuk mencatat kehadiran
        // Koneksi ke database
        include_once('config/database.php');
        
        // Misalkan ada tabel presensi yang mencatat ID jemaat dan waktu kehadiran
        $query = "INSERT INTO presensi (qr_code_data, timestamp) VALUES (?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('s', $qr_code_data);
        $stmt->execute();
        
        if ($stmt->affected_rows > 0) {
            $response = [
                'status' => 'success',
                'message' => 'Presensi berhasil untuk: ' . htmlspecialchars($qr_code_data),
            ];
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Gagal mencatat presensi!',
            ];
        }

        $stmt->close();
        $conn->close();
    } else {
        $response = [
            'status' => 'error',
            'message' => 'Data QR code tidak valid!',
        ];
    }

    // Kirim respons dalam format JSON
    echo json_encode($response);
    exit;
} else {
    // Respons jika metode bukan POST
    echo json_encode([
        'status' => 'error',
        'message' => 'Metode tidak diizinkan!',
    ]);
    exit;
}
?>
