<?php 
session_start();
require_once 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $password = trim($_POST['password']);  // Menggunakan $password, bukan $raw_password

    if(empty($name) || empty($password)) { // Menggunakan $password
        $error = "Nama dan password wajib diisi";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM login WHERE name = ?");
        $stmt->execute([$name]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($user && password_verify($password, $user['password'])) { // Menggunakan $password
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Nama atau password salah";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/style/loginx.css">
</head>
<body>
    <div class="form-container">
        <h2>Login</h2>

        <?php if (!empty($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="name">Nama Pengguna:</label>
            <input type="text" id="name" name="name" required>

            <label for="password">Kata Sandi:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login Bro</button>

            <p>Belum punya akun? <a href="register.php">Daftar dulu</a></p>
        </form>
    </div>
</body>
</html>
