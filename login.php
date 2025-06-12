<?php
session_start();
$koneksi = new mysqli("localhost", "root", "", "uaspw");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $email = $koneksi->real_escape_string($_POST['email']);
  $password = $_POST['password'];

  $data = $koneksi->query("SELECT * FROM users WHERE email = '$email'");
  if ($data->num_rows > 0) {
    $user = $data->fetch_assoc();
    if (password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];
      $_SESSION['user_nama'] = $user['nama'];
      header("Location: index.php"); // diarahkan ke index.php setelah login sukses
      exit;
    } else {
      $error = "Password salah!";
    }
  } else {
    $error = "Email tidak ditemukan!";
  }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Login - Rambu Resto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
    }
    .login-container {
      max-width: 400px;
      margin: 80px auto;
      padding: 30px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2 class="text-center mb-4">Login ke Rambu Resto</h2>
    <?php if (!empty($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>
    <form method="POST" action="">
      <div class="mb-3">
        <label for="email" class="form-label">Email:</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi:</label>
        <input type="password" name="password" id="password" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <div class="text-center mt-3">
        <p>Belum punya akun? <a href="register.php">Daftar di sini</a></p>
      </div>
    </form>
  </div>
</body>
</html>

