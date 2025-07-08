<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET['id'])) {
    echo "ID blog tidak ditemukan.";
    exit;
}

$id = $_GET['id'];

// Ambil data blog
$stmt = $pdo->prepare("SELECT * FROM blog WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $_SESSION['user_id']]);
$blog = $stmt->fetch();

if (!$blog) {
    echo "Postingan tidak ditemukan atau bukan milik Anda.";
    exit;
}

// Update jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul = $_POST['judul'] ?? '';
    $deskripsi = $_POST['deskripsi'] ?? '';

    $update = $pdo->prepare("UPDATE blog SET judul = ?, deskripsi = ?, updated_at = NOW() WHERE id = ? AND user_id = ?");
    $update->execute([$judul, $deskripsi, $id, $_SESSION['user_id']]);

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="style/indexs.css">
</head>
<body>
    <h1>Edit Postingan</h1>
    <form method="post">
        <label>Judul:</label><br>
        <input type="text" name="judul" value="<?= htmlspecialchars($blog['judul']) ?>"><br><br>
        <label>Deskripsi:</label><br>
        <textarea name="deskripsi" rows="8" cols="40"><?= htmlspecialchars($blog['deskripsi']) ?></textarea><br><br>
        <button type="submit">Simpan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>
