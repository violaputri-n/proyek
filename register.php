<?php
$koneksi = new mysqli("localhost", "root", "", "uaspw");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $nama = $koneksi->real_escape_string($_POST['nama']);
  $email = $koneksi->real_escape_string($_POST['email']);
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $cek = $koneksi->query("SELECT id FROM users WHERE email = '$email'");
  if ($cek->num_rows > 0) {
    $error = "Email sudah digunakan!";
  } else {
    $koneksi->query("INSERT INTO users (nama, email, password) VALUES ('$nama', '$email', '$password')");
    header("Location: login.php?success=1");
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Daftar Akun - Rambu Resto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f8f9fa;
      font-family: 'Poppins', sans-serif;
    }
    .form-container {
      max-width: 500px;
      margin: 60px auto;
      padding: 2rem;
      background: white;
      border-radius: 10px;
      box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    }
    .form-title {
      margin-bottom: 1.5rem;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="form-container">
    <h3 class="form-title text-center">Daftar Akun</h3>

    <?php if (isset($error)): ?>
      <div class="alert alert-danger"><?= $error ?></div>
    <?php endif; ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label for="nama" class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" id="nama" name="nama" required>
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Alamat Email</label>
        <input type="email" class="form-control" id="email" name="email" required>
      </div>
      <div class="mb-3">
        <label for="password" class="form-label">Kata Sandi</label>
        <input type="password" class="form-control" id="password" name="password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Daftar</button>
    </form>

    <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login di sini</a>.</p>
  </div>
</div>

</body>
</html>
