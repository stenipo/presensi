<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah 'majelis'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'majelis') {
    header("Location: login.php");
    exit();
}

// Sertakan koneksi database
require_once('../src/config/database.php');

// Fungsi untuk menghasilkan QR Code dan menggabungkannya dengan data diri jemaat
function generateQRWithData($data, $jemaatName, $jemaatData) {
    // Memastikan bahwa library QR Code sudah terpasang
    include('../vendor/autoload.php');
    
    // Membuat objek QR Code
    $qrCode = new \Endroid\QrCode\QrCode($data);
    
    // Menyimpan QR Code ke file sementara
    $writer = new \Endroid\QrCode\Writer\PngWriter();
    $tempQrCodePath = 'images/qrcodes/temp_' . $jemaatName . '.png';
    $writer->write($qrCode)->saveToFile($tempQrCodePath);  // Simpan file QR code sementara
    
    // Membaca gambar QR Code
    $qrImage = imagecreatefrompng($tempQrCodePath);

    // Ukuran gambar dan teks
    $width = imagesx($qrImage);
    $height = imagesy($qrImage);
    
    // Membuat gambar baru dengan lebar untuk menampung QR Code dan data diri
    $newWidth = $width + 400; // Tambahkan ruang untuk data diri
    $newHeight = $height + 200; // Tambahkan ruang untuk data diri
    $newImage = imagecreatetruecolor($newWidth, $newHeight);
    
    // Mengisi latar belakang dengan warna putih
    $white = imagecolorallocate($newImage, 255, 255, 255);
    imagefill($newImage, 0, 0, $white);
    
    // Menyalin QR Code ke gambar baru
    imagecopy($newImage, $qrImage, 0, 0, 0, 0, $width, $height);
    
    // Mengatur font untuk teks
    $fontPath = 'fonts/arial.ttf'; // Ganti dengan path ke file font di sistem Anda
    $black = imagecolorallocate($newImage, 0, 0, 0);
    
    // Menambahkan data diri jemaat ke gambar
    $yOffset = $height + 20; // Posisi Y teks (setelah QR Code)
    imagettftext($newImage, 20, 0, 10, $yOffset, $black, $fontPath, "Nama: " . $jemaatData['nama']);
imagettftext($newImage, 20, 0, 10, $yOffset + 30, $black, $fontPath, "Jenis Kelamin: " . $jemaatData['jenis_kelamin']);
imagettftext($newImage, 20, 0, 10, $yOffset + 60, $black, $fontPath, "Alamat: " . $jemaatData['alamat']);
imagettftext($newImage, 20, 0, 10, $yOffset + 90, $black, $fontPath, "Tanggal Lahir: " . $jemaatData['tanggal_lahir']);
imagettftext($newImage, 20, 0, 10, $yOffset + 120, $black, $fontPath, "Sektor: " . $jemaatData['sektor']);
imagettftext($newImage, 20, 0, 10, $yOffset + 150, $black, $fontPath, "Nomor Telepon: " . $jemaatData['nomor_telepon']);

    
    // Menyimpan gambar gabungan ke file
    $finalImagePath = 'images/qrcodes/' . strtolower(str_replace(' ', '_', $jemaatName)) . '_with_data.png';
    imagepng($newImage, $finalImagePath);  // Simpan file gambar
    
    // Membersihkan gambar sementara
    imagedestroy($qrImage);
    imagedestroy($newImage);
    
    // Mengembalikan path gambar akhir
    return $finalImagePath;
}

// Ambil data jemaat dari database
$query = "SELECT * FROM jemaat";
$stmt = $conn->prepare($query);
$stmt->execute();
$jemaat = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Proses untuk membuat QR Code dengan data diri jemaat
$qrCodePath = '';
$jemaatData = [];
if (isset($_POST['generate'])) {
    $jemaat_id = $_POST['jemaat_id']; // ID jemaat yang dipilih
    
    // Ambil data jemaat yang dipilih
    $stmt = $conn->prepare("SELECT * FROM jemaat WHERE id = :id");
    $stmt->bindParam(':id', $jemaat_id);
    $stmt->execute();
    $jemaatData = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($jemaatData) {
        $qrCodePath = generateQRWithData($jemaat_id, $jemaatData['nama'], $jemaatData); // Generate QR Code dengan data diri
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat QR Code dengan Data Diri</title>
    <!-- Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="majelis_dashboard.php">
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
        <h2 class="text-center">Buat QR Code dengan Data Diri Jemaat</h2>
        <form method="post" action="">
            <div class="form-group">
                <label for="jemaat_id">Pilih Jemaat:</label>
                <select name="jemaat_id" id="jemaat_id" class="form-control" required>
                    <option value="">Pilih Jemaat</option>
                    <?php foreach ($jemaat as $row): ?>
                        <option value="<?= $row['id']; ?>"><?= htmlspecialchars($row['nama']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="generate" class="btn btn-primary">Generate QR Code</button>
        </form>

        <hr>

        <?php if ($qrCodePath): ?>
            <div class="text-center">
                <h4>QR Code dan Data Diri Jemaat:</h4>
                <img src="<?= $qrCodePath; ?>" alt="QR Code with Data">
                <br>
                <a href="<?= $qrCodePath; ?>" download="<?= basename($qrCodePath); ?>" class="btn btn-success mt-3">Unduh QR Code dengan Data Diri</a>
            </div>
        <?php endif; ?>

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
