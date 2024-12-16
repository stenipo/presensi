<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simulasi Pencatatan dan Pengelolaan Data Kehadiran Jemaat HKBP Buhit</title>
    <!-- Menyertakan link ke Bootstrap 4 -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <!-- Logo -->
                <div class="text-center mb-4">
                    <img src="images/hkbp-logo.png" alt="HKBP Buhit Logo" class="img-fluid" style="max-width: 150px;">
                </div>
                <h2 class="text-center mb-4">Simulasi Pencatatan dan Pengelolaan Data Kehadiran Jemaat HKBP Buhit</h2>
                <!-- Ketengan atau Deskripsi Aplikasi -->
               
                <!-- Form Login -->
                <form action="../src/controllers/login_process.php" method="POST" id="loginForm">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                </form>
                <div class="text-center mt-3">
                    <a href="register.php">Daftar Jemaat Disini
                    
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Menyertakan JavaScript untuk Bootstrap dan jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>
