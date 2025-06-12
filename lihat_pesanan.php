<?php
include 'koneksi.php';

$pesanan = $conn->query("
  SELECT orders.id, users.nama, orders.tanggal, orders.total_harga
  FROM orders
  JOIN users ON orders.user_id = users.id
  ORDER BY orders.tanggal DESC
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lihat Pesanan</title>
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
    .sidebar h4 {
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
    .sidebar a.active {
      font-weight: bold;
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
      <a href="lihat_pesanan.php" class="active">Lihat Pesanan</a>
      <a href="pengguna.php">Pengguna</a>
      <a href="isi_kritiksaran.php">Kritik & Saran</a>
      <a href="logout.php" class="mt-auto border-top">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Lihat Pesanan</h2>
      <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nama Pengguna</th>
            <th>Tanggal</th>
            <th>Total Harga</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $pesanan->fetch_assoc()): ?>
            <tr>
              <td><?= $row['id'] ?></td>
              <td><?= htmlspecialchars($row['nama']) ?></td>
              <td><?= $row['tanggal'] ?></td>
              <td>Rp<?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
