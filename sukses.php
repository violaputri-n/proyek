<?php
// sukses.php
session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "uaspw";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Koneksi gagal: " . $conn->connect_error);
}

// Ambil user_id dari sesi
$user_id = $_SESSION['user_id'] ?? 0;
if (!$user_id) {
  die("User tidak ditemukan. Harap login terlebih dahulu.");
}

// Ambil order terakhir milik user ini
$stmt = $conn->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
  die("Tidak ada pesanan ditemukan untuk user ini.");
}

$order = $result->fetch_assoc();
$order_id = $order['id'];
$tanggal = $order['tanggal'];
$total_harga = $order['total_harga'];

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <title>Checkout Berhasil</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    .checkmark {
      width: 100px;
      height: 100px;
      margin: 20px auto;
    }
    .checkmark-circle {
      stroke-dasharray: 166;
      stroke-dashoffset: 166;
      stroke-width: 2;
      stroke-miterlimit: 10;
      stroke: #28a745;
      fill: none;
      animation: stroke 0.6s cubic-bezier(0.65, 0, 0.45, 1) forwards;
    }
    .checkmark-check {
      transform-origin: 50% 50%;
      stroke-dasharray: 48;
      stroke-dashoffset: 48;
      stroke-width: 2;
      stroke: #28a745;
      fill: none;
      animation: stroke 0.4s 0.6s ease-in-out forwards;
    }
    @keyframes stroke {
      100% {
        stroke-dashoffset: 0;
      }
    }
  </style>
</head>
<body class="bg-light p-5">
  <div class="container text-center">
    <svg class="checkmark" viewBox="0 0 52 52">
      <circle class="checkmark-circle" cx="26" cy="26" r="25"/>
      <path class="checkmark-check" fill="none" d="M14 27l7 7 16-16"/>
    </svg>

    <h1 class="text-success mb-3">Pesanan Berhasil!</h1>
    <p class="lead">Terima kasih telah memesan di <strong>Rambu Resto</strong>.</p>

    <div class="card shadow-sm p-4 my-4 mx-auto" style="max-width: 500px;">
      <h5>Detail Pesanan</h5>
      <ul class="list-group text-start mt-3">
        <li class="list-group-item"><strong>ID Pesanan:</strong> #<?= $order_id ?></li>
        <li class="list-group-item"><strong>Tanggal & Waktu:</strong> <?= $tanggal ?></li>
        <li class="list-group-item"><strong>Total Harga:</strong> Rp<?= number_format($total_harga, 0, ',', '.') ?></li>
      </ul>
    </div>

    <div class="d-flex justify-content-center gap-3">
      <a href="pesanan.php" class="btn btn-outline-success">Lihat Riwayat Pesanan</a>
      <a href="index.php" class="btn btn-primary">Kembali ke Beranda</a>
    </div>
  </div>
</body>
</html>
