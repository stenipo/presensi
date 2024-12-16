<?php
session_start();
require_once('../src/config/database.php');

// Memastikan pengguna login dan memiliki role sebagai majelis
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'majelis') {
    header("Location: ../public/login.php");
    exit();
}

// Mendapatkan ID jemaat dari URL
$id = $_GET['id'];

// Hapus data jemaat dari database
$query = $conn->prepare("DELETE FROM jemaat WHERE id = :id");
$query->bindParam(':id', $id);
$query->execute();

// Redirect setelah penghapusan
header('Location: manage_jemaat.php');
exit();
?>
