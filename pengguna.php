<?php
include 'koneksi.php';

$users = $conn->query("SELECT * FROM users ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Data Pengguna</title>
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
      <a href="lihat_pesanan.php">Lihat Pesanan</a>
      <a href="pengguna.php" class="active">Pengguna</a>
      <a href="isi_kritiksaran.php">Kritik & Saran</a>
      <a href="logout.php" class="mt-auto border-top">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 p-4">
      <h2 class="mb-4">Data Pengguna</h2>
      <table class="table table-bordered table-striped mt-4">
        <thead class="table-dark">
          <tr>
            <th>ID</th>
            <th>Nama</th>
            <th>Email</th>
            <th>Tanggal Daftar</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
              <td><?= $user['id'] ?></td>
              <td><?= htmlspecialchars($user['nama']) ?></td>
              <td><?= htmlspecialchars($user['email']) ?></td>
              <td><?= $user['created_at'] ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
</body>
</html>
