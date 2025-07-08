<?php
$host = '192.168.0.80';  // Nama service atau container MySQL
$db_name = 'web_blog';
$username = 'root';
$password = 'p455w0rd';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>
