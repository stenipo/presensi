<?php
session_start();

// Periksa apakah user sudah login dan role-nya adalah 'majelis'
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'majelis') {
    header("Location: login.php");
    exit();
}

// Sertakan koneksi database
require_once('../src/config/database.php');

// Ambil data jemaat dari database
$query = "SELECT * FROM jemaat";
$stmt = $conn->prepare($query);
$stmt->execute();
$jemaat = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Jemaat</title>
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
        <h2 class="text-center">Manajemen Data Jemaat</h2>
        <!-- Button Trigger untuk Modal Tambah -->
        <button class="btn btn-success mb-3" data-toggle="modal" data-target="#tambahJemaatModal">Tambah Jemaat</button>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Tanggal Lahir</th>
                    <th>Sektor</th>
                    <th>Nomor Telepon</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($jemaat as $index => $row): ?>
                    <tr>
                        <td><?= $index + 1; ?></td>
                        <td><?= htmlspecialchars($row['nama']); ?></td>
                        <td><?= htmlspecialchars($row['jenis_kelamin']); ?></td>
                        <td><?= htmlspecialchars($row['alamat']); ?></td>
                        <td><?= htmlspecialchars($row['tanggal_lahir']); ?></td>
                        <td><?= htmlspecialchars($row['sektor']); ?></td>
                        <td><?= htmlspecialchars($row['nomor_telepon']); ?></td>
                        <td>
                            <!-- Tombol untuk Edit Jemaat -->
                            <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editJemaatModal" 
                                    data-id="<?= $row['id']; ?>"
                                    data-nama="<?= htmlspecialchars($row['nama']); ?>"
                                    data-jenis_kelamin="<?= htmlspecialchars($row['jenis_kelamin']); ?>"
                                    data-alamat="<?= htmlspecialchars($row['alamat']); ?>"
                                    data-tanggal_lahir="<?= htmlspecialchars($row['tanggal_lahir']); ?>"
                                    data-sektor="<?= htmlspecialchars($row['sektor']); ?>"
                                    data-nomor_telepon="<?= htmlspecialchars($row['nomor_telepon']); ?>">Edit</button>
                            <a href="delete_jemaat.php?id=<?= $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Tambah Jemaat -->
    <div class="modal fade" id="tambahJemaatModal" tabindex="-1" role="dialog" aria-labelledby="tambahJemaatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahJemaatModalLabel">Tambah Jemaat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="tambah_jemaat.php" method="POST">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="form-group">
    <label for="jenis_kelamin">Jenis Kelamin</label>
    <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>
</div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="sektor">Sektor</label>
                            <input type="text" class="form-control" id="sektor" name="sektor" required>
                        </div>
                        <div class="form-group">
                            <label for="nomor_telepon">Nomor Telepon</label>
                            <input type="text" class="form-control" id="nomor_telepon" name="nomor_telepon" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Jemaat -->
    <div class="modal fade" id="editJemaatModal" tabindex="-1" role="dialog" aria-labelledby="editJemaatModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editJemaatModalLabel">Edit Jemaat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="edit_jemaat.php" method="POST">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="form-group">
                            <label for="edit_nama">Nama</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" required>
                        </div>
                        <div class="form-group">
    <label for="edit_jenis_kelamin">Jenis Kelamin</label>
    <select class="form-control" id="edit_jenis_kelamin" name="jenis_kelamin" required>
        <option value="L">Laki-laki</option>
        <option value="P">Perempuan</option>
    </select>
</div>

                        <div class="form-group">
                            <label for="edit_alamat">Alamat</label>
                            <input type="text" class="form-control" id="edit_alamat" name="alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_sektor">Sektor</label>
                            <input type="text" class="form-control" id="edit_sektor" name="sektor" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_nomor_telepon">Nomor Telepon</label>
                            <input type="text" class="form-control" id="edit_nomor_telepon" name="nomor_telepon" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
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

    <script>
        // Skrip untuk mengisi modal edit dengan data yang sudah ada
        $('#editJemaatModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Tombol yang diklik
            var id = button.data('id');
            var nama = button.data('nama');
            var jenis_kelamin = button.data('jenis_kelamin');
            var alamat = button.data('alamat');
            var tanggal_lahir = button.data('tanggal_lahir');
            var sektor = button.data('sektor');
            var nomor_telepon = button.data('nomor_telepon');

            // Isi data pada modal
            $('#edit_id').val(id);
            $('#edit_nama').val(nama);
            $('#edit_jenis_kelamin').val(jenis_kelamin);
            $('#edit_alamat').val(alamat);
            $('#edit_tanggal_lahir').val(tanggal_lahir);
            $('#edit_sektor').val(sektor);
            $('#edit_nomor_telepon').val(nomor_telepon);
        });
    </script>
</body>
</html>