<?php
session_start();

// Cek apakah user sudah login
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

// Hapus item
if (isset($_GET['hapus']) && is_numeric($_GET['hapus'])) {
  $id = (int) $_GET['hapus'];
  $conn->query("DELETE FROM cart WHERE id = $id AND user_id = $user_id");
  header("Location: cart.php");
  exit;
}

// Kurangi jumlah
if (isset($_GET['kurang']) && is_numeric($_GET['kurang'])) {
  $id = (int) $_GET['kurang'];
  $res = $conn->query("SELECT * FROM cart WHERE id = $id AND user_id = $user_id");
  if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $new_qty = $row['jumlah_pesanan'] - 1;
    if ($new_qty > 0) {
      $new_subtotal = ($row['harga'] + $row['pajak']) * $new_qty;
      $conn->query("UPDATE cart SET jumlah_pesanan = $new_qty, subtotal = $new_subtotal WHERE id = $id AND user_id = $user_id");
    } else {
      $conn->query("DELETE FROM cart WHERE id = $id AND user_id = $user_id");
    }
  }
  header("Location: cart.php");
  exit;
}

// Tambah jumlah
if (isset($_GET['tambah']) && is_numeric($_GET['tambah'])) {
  $id = (int) $_GET['tambah'];
  $res = $conn->query("SELECT * FROM cart WHERE id = $id AND user_id = $user_id");
  if ($res && $res->num_rows > 0) {
    $row = $res->fetch_assoc();
    $new_qty = $row['jumlah_pesanan'] + 1;
    $new_subtotal = ($row['harga'] + $row['pajak']) * $new_qty;
    $conn->query("UPDATE cart SET jumlah_pesanan = $new_qty, subtotal = $new_subtotal WHERE id = $id AND user_id = $user_id");
  }
  header("Location: cart.php");
  exit;
}

// Proses checkout
if (isset($_POST['checkout'])) {
  $result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
  if ($result->num_rows > 0) {
    $total_harga = 0;
    while ($row = $result->fetch_assoc()) {
      $total_harga += $row['subtotal'];
    }

    $tanggal = date('Y-m-d H:i:s');
    $conn->query("INSERT INTO orders (user_id, tanggal, total_harga) VALUES ($user_id, '$tanggal', $total_harga)");
    $order_id = $conn->insert_id;

    // Simpan ke order_details
    $result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
    while ($row = $result->fetch_assoc()) {
      $nama = $conn->real_escape_string($row['nama_makanan']);
      $jumlah = (int) $row['jumlah_pesanan'];
      $harga = (int) $row['harga'];
      $pajak = (int) $row['pajak'];
      $subtotal = (int) $row['subtotal'];
      $conn->query("INSERT INTO order_details (order_id, nama_makanan, jumlah_pesanan, harga, pajak, subtotal) VALUES ($order_id, '$nama', $jumlah, $harga, $pajak, $subtotal)");
    }

    $conn->query("DELETE FROM cart WHERE user_id = $user_id");
    header("Location: sukses.php");
    exit;
  } else {
    echo "<script>alert('Keranjang kosong.');</script>";
  }
}

// Ambil isi keranjang
$result = $conn->query("SELECT * FROM cart WHERE user_id = $user_id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Keranjang Anda</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">
  <div class="container">
    <h2 class="mb-4">Isi Keranjang</h2>
    <?php if ($result->num_rows > 0): ?>
    <form method="POST" action="cart.php">
      <table class="table table-bordered text-center">
        <thead class="table-warning">
          <tr>
            <th>Nama Makanan</th>
            <th>Jumlah</th>
            <th>Harga</th>
            <th>PPN</th>
            <th>Total</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= htmlspecialchars($row['nama_makanan']) ?></td>
            <td>
              <a href="cart.php?kurang=<?= $row['id'] ?>" class="btn btn-sm btn-warning">-</a>
              <span class="mx-2"><?= $row['jumlah_pesanan'] ?></span>
              <a href="cart.php?tambah=<?= $row['id'] ?>" class="btn btn-sm btn-success">+</a>
            </td>
            <td>Rp<?= number_format($row['harga'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($row['pajak'], 0, ',', '.') ?></td>
            <td>Rp<?= number_format($row['subtotal'], 0, ',', '.') ?></td>
            <td>
              <a href="cart.php?hapus=<?= $row['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus item ini?')">Hapus</a>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
      <button type="submit" name="checkout" class="btn btn-primary">Checkout</button>
    </form>
    <?php else: ?>
      <p>Keranjang kosong.</p>
    <?php endif; ?>
  </div>
</body>
</html>
