<?php
session_start();
require_once 'conn.php';

// Cek login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = trim($_POST['judul']);
    $deskripsi = trim($_POST['deskripsi']);
    $userId = $_SESSION['user_id'];

    if (!empty($judul) && !empty($deskripsi)) {
        $stmt = $pdo->prepare("INSERT INTO blog (user_id, judul, deskripsi) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $judul, $deskripsi]);
        header("Location: index.php");
        exit;
    } else {
        $error = "Judul dan deskripsi tidak boleh kosong.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Postingan</title>
    <link rel="stylesheet" href="style/blog.css">
</head>
<body>
    <div class="form-container">
        <h1>Tambah Postingan Blog</h1>

        <?php if (!empty($error)): ?>
            <p class="error-message"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="POST" action="">
            <div>
                <label for="judul">Judul:</label>
                <input type="text" id="judul" name="judul" required>
            </div>
            
            <br>

            <div>
                <label for="deskripsi">Deskripsi:</label>
                <textarea id="deskripsi" name="deskripsi" rows="8" required></textarea>
            </div>

            <div class="form-actions">
                <button type="submit">Simpan Postingan</button>
                <a href="index.php">Kembali</a>
            </div>
        </form>
    </div>
</body>
</html>
