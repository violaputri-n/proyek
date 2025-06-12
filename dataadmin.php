<?php
include 'koneksi.php';

// Ambil total pengguna
$result_users = $conn->query("SELECT COUNT(*) as total_users FROM users");
$totalPengguna = $result_users->fetch_assoc()['total_users'];

// Ambil total pesanan
$result_orders = $conn->query("SELECT COUNT(*) as total_orders FROM orders");
$totalPesanan = $result_orders->fetch_assoc()['total_orders'];

// Ambil total pendapatan
$result_income = $conn->query("SELECT SUM(total_harga) as total_income FROM orders");
$totalPendapatan = $result_income->fetch_assoc()['total_income'];

// Ambil ringkasan pesanan terbaru (join dengan users)
$ringkasan = $conn->query("
    SELECT orders.id, users.nama, orders.tanggal, orders.total_harga
    FROM orders
    JOIN users ON orders.user_id = users.id
    ORDER BY orders.tanggal DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Admin Panel</title>
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
      <h2 class="mb-4">Dashboard Admin</h2>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card shadow p-3">
            <h5>Total Pengguna</h5>
            <h3 class="text-primary"><?= $totalPengguna ?></h3>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow p-3">
            <h5>Total Pesanan</h5>
            <h3 class="text-success"><?= $totalPesanan ?></h3>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card shadow p-3">
            <h5>Total Pendapatan</h5>
            <h3 class="text-danger">Rp<?= number_format($totalPendapatan, 0, ',', '.') ?></h3>
          </div>
        </div>
      </div>

      <div class="mt-5">
        <h4>Ringkasan Terbaru</h4>
        <table class="table table-striped table-bordered mt-3">
          <thead class="table-dark">
            <tr>
              <th>#</th>
              <th>Nama Pengguna</th>
              <th>Tanggal</th>
              <th>Total</th>
            </tr>
          </thead>
          <tbody>
            <?php $no = 1; while ($row = $ringkasan->fetch_assoc()): ?>
              <tr>
                <td><?= $no++ ?></td>
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
</div>
</body>
</html>
