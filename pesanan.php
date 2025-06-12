<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit;
}

$user_id = $_SESSION['user_id'];

$host = "localhost";
$user = "root";
$pass = "";
$db   = "uaspw";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil semua pesanan milik user ini
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY tanggal DESC");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$orders = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Pesanan</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body class="bg-light p-4">
  <div class="container">
    <h2 class="mb-4 text-center">Riwayat Pesanan Anda</h2>

    <?php if ($orders->num_rows > 0): ?>
      <?php while ($order = $orders->fetch_assoc()): ?>
        <div class="card shadow-sm mb-4">
          <div class="card-header bg-primary text-white">
            <strong>ID Pesanan:</strong> <?= $order['id'] ?> |
            <strong>Tanggal:</strong> <?= $order['tanggal'] ?> |
            <strong>Total:</strong> Rp<?= number_format($order['total_harga'], 0, ',', '.') ?>
          </div>
          <div class="card-body p-0">
            <table class="table table-bordered table-hover m-0">
              <thead class="table-light">
                <tr>
                  <th>Nama Makanan</th>
                  <th>Jumlah</th>
                  <th>Harga</th>
                  <th>PPN</th>
                  <th>Subtotal</th>
                </tr>
              </thead>
              <tbody>
              <?php
              $order_id = $order['id'];
              $detail_stmt = $conn->prepare("SELECT * FROM order_details WHERE order_id = ?");
              $detail_stmt->bind_param("i", $order_id);
              $detail_stmt->execute();
              $details = $detail_stmt->get_result();

              while ($item = $details->fetch_assoc()):
              ?>
                <tr>
                  <td><?= htmlspecialchars($item['nama_makanan']) ?></td>
                  <td><?= $item['jumlah_pesanan'] ?></td>
                  <td>Rp<?= number_format($item['harga'], 0, ',', '.') ?></td>
                  <td>Rp<?= number_format($item['pajak'], 0, ',', '.') ?></td>
                  <td>Rp<?= number_format($item['subtotal'], 0, ',', '.') ?></td>
                </tr>
              <?php endwhile; $detail_stmt->close(); ?>
              </tbody>
            </table>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p class="alert alert-warning text-center">Belum ada pesanan.</p>
    <?php endif; ?>

    <div class="text-center mt-4">
      <a href="index.php" class="btn btn-secondary">Kembali ke Beranda</a>
    </div>
  </div>
</body>
</html>
