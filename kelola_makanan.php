<?php
include 'koneksi.php';

$result = $conn->query("SELECT * FROM makanan ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Kelola Makanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #f4f6f9;
    }
    .sidebar {
      height: 100vh;
      background: #343a40;
      color: white;
    }
    .sidebar a {
      color: white;
      display: block;
      padding: 15px;
      text-decoration: none;
    }
    .sidebar a:hover {
      background: #495057;
    }
    .card {
      border-radius: 15px;
    }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar d-flex flex-column">
      <h4 class="text-center py-3 border-bottom">Admin Panel</h4>
      <a href="dataadmin.php">Dashboard</a>
      <a href="kelola_makanan.php">Kelola Makanan</a>
      <a href="lihat_pesanan.php">Lihat Pesanan</a>
      <a href="pengguna.php">Pengguna</a>
      <a href="isi_kritiksaran.php">Kritik & Saran</a>
      <a href="logout.php" class="mt-auto border-top">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Kelola Makanan</h2>
      <div class="mb-3">
        <a href="tambahmakanan.php" class="btn btn-primary">Tambah Makanan</a>
      </div>
      <table class="table table-striped table-bordered">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nama Makanan</th>
            <th>Harga</th>
            <th>Kategori</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
                <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
                <td><?= htmlspecialchars($row['kategori']) ?></td>
                <td>
                  <a href="#" class="btn btn-sm btn-warning">Edit</a>
                  <a href="#" class="btn btn-sm btn-danger">Hapus</a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">Belum ada data makanan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
