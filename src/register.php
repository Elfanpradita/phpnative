<?php
require_once 'conn.php'; // Koneksi ke database

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $raw_password = trim($_POST["password"]);

    // Validasi input
    if (empty($name) || empty($raw_password)) {
        $error = "Nama dan password tidak boleh kosong.";
    } else {
        // Cek apakah nama sudah ada di database
        $stmt = $pdo->prepare("SELECT id FROM login WHERE name = ?");
        $stmt->execute([$name]);

        if ($stmt->rowCount() > 0) {
            $error = "Nama pengguna sudah terdaftar. Silakan pilih nama lain.";
        } else {
            // Meng-hash password sebelum disimpan
            $hashed_password = password_hash($raw_password, PASSWORD_DEFAULT);

            // Insert data pengguna baru ke dalam database
            $stmt = $pdo->prepare("INSERT INTO login (name, password) VALUES (?, ?)");
            if ($stmt->execute([$name, $hashed_password])) {
                $success = "Registrasi berhasil. Silakan login.";
            } else {
                $error = "Terjadi kesalahan saat menyimpan data.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="/style/loginx.css">
</head>
<body>
    <div class="form-container">
        <h2>Registrasi</h2>

        <!-- Menampilkan pesan error jika ada -->
        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <!-- Menampilkan pesan sukses jika berhasil -->
        <?php if (!empty($success)): ?>
            <div class="success-message">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <!-- Form registrasi -->
        <form method="POST" action="">
            <label for="name">Nama Pengguna:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Kata Sandi:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Daftar</button>

            <p>Sudah punya akun? <a href="login.php">Login di sini</a></p>
        </form>
    </div>
</body>
</html>
