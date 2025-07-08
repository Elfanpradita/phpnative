<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$currentUserId = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT blog.*, login.name AS penulis
    FROM blog
    JOIN login ON blog.user_id = login.id
    WHERE blog.user_id = ?
    ORDER BY blog.created_at DESC
");
$stmt->execute([$currentUserId]);
$blogs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Blog Saya</title>
    <link rel="stylesheet" href="style/indexs.css">
</head>
<body>

    <header>
        <h1>Daftar Postingan Saya</h1>
        <nav>
            <a href="tambah_blog.php">➕ Tambah Postingan</a> |
            <a href="logout.php">🚪 Logout</a>
        </nav>
        <hr>
    </header>

    <div class="blog-container">
        <?php if (!empty($blogs)): ?>
            <?php foreach ($blogs as $blog): ?>
                <div class="blog-post">
                    <h2><?= htmlspecialchars($blog['judul'] ?? 'Tanpa Judul') ?></h2>
                    <p><strong>Penulis:</strong> <?= htmlspecialchars($blog['penulis'] ?? 'Tidak diketahui') ?></p>
                    <p><?= nl2br(htmlspecialchars($blog['deskripsi'] ?? '')) ?></p>
                    <p><em>Dibuat pada: <?= isset($blog['created_at']) ? date("d-m-Y H:i", strtotime($blog['created_at'])) : 'Tanggal tidak tersedia' ?></em></p>

                    <p>
                        <a href="edit_blog.php?id=<?= htmlspecialchars($blog['id']) ?>">✏️ Edit</a> |
                        <a href="hapus.php?id=<?= htmlspecialchars($blog['id']) ?>" onclick="return confirm('Yakin ingin menghapus postingan ini?')">🗑️ Hapus</a>
                    </p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Belum ada postingan blog.</p>
        <?php endif; ?>
    </div>

</body>
</html>
