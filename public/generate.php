<?php
$password = 'majelis';  // Gantilah dengan password yang ingin Anda hash
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;  // Tampilkan hasil hash
?>
