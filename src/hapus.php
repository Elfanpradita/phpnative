<?php
session_start();
require_once 'conn.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$userId = $_SESSION['user_id'];
$blogId = $_GET['id'] ?? null;

if (!$blogId) {
    header("Location: index.php");
    exit;
}

// Hanya hapus jika user adalah pemilik
$stmt = $pdo->prepare("DELETE FROM blog WHERE id = ? AND user_id = ?");
$stmt->execute([$blogId, $userId]);

header("Location: index.php");
exit;
