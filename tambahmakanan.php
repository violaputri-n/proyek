<?php
include 'koneksi.php';

// Proses jika form disubmit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nama = $_POST['nama'];
  $harga = $_POST['harga'];
  $kategori = $_POST['kategori'];

  // Validasi sederhana
  if (!empty($nama) && is_numeric($harga) && !empty($kategori)) {
    $stmt = $conn->prepare("INSERT INTO makanan (nama_makanan, harga, kategori) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama, $harga, $kategori);
    $stmt->execute();

    header("Location: kelola_makanan.php");
    exit;
  } else {
    $error = "Pastikan semua field diisi dengan benar!";
  }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Tambah Makanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h2>Tambah Makanan</h2>

  <?php if (isset($error)): ?>
    <div class="alert alert-danger"><?= $error ?></div>
  <?php endif; ?>

  <form method="POST">
    <div class="mb-3">
      <label for="nama" class="form-label">Nama Makanan</label>
      <input type="text" name="nama" id="nama" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="harga" class="form-label">Harga</label>
      <input type="number" name="harga" id="harga" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="kategori" class="form-label">Kategori</label>
      <input type="text" name="kategori" id="kategori" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="kelola_makanan.php" class="btn btn-secondary">Batal</a>
  </form>
</div>
</body>
</html>
