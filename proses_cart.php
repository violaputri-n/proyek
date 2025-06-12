<?php
header('Content-Type: application/json');
session_start();

if (!isset($_SESSION['user_id'])) {
  echo json_encode(["status" => "error", "message" => "User belum login"]);
  exit;
}

$user_id = $_SESSION['user_id'];

// Koneksi database
$conn = new mysqli("localhost", "root", "", "uaspw");
if ($conn->connect_error) {
  echo json_encode(["status" => "error", "message" => "Koneksi gagal ke database"]);
  exit;
}

// Ambil data dari POST
$nama_makanan = $_POST['menu_name'] ?? '';
$harga = (int) ($_POST['price'] ?? 0);
$jumlah = (int) ($_POST['quantity'] ?? 1);

if (empty($nama_makanan) || $harga <= 0 || $jumlah <= 0) {
  echo json_encode(["status" => "error", "message" => "Data tidak valid"]);
  exit;
}

// Hitung PPN dan subtotal
$ppn = round($harga * $jumlah * 0.12);
$subtotal = ($harga * $jumlah) + $ppn;

// Escape nama makanan
$nama_makanan = $conn->real_escape_string($nama_makanan);

// Cek apakah makanan sudah ada di keranjang
$cek = $conn->query("SELECT * FROM cart WHERE user_id = $user_id AND nama_makanan = '$nama_makanan'");
if ($cek && $cek->num_rows > 0) {
  $row = $cek->fetch_assoc();
  $new_qty = $row['jumlah_pesanan'] + $jumlah;
  $new_ppn = round($harga * $new_qty * 0.12);
  $new_subtotal = ($harga * $new_qty) + $new_ppn;

  $update = $conn->query("UPDATE cart SET jumlah_pesanan = $new_qty, pajak = $new_ppn, subtotal = $new_subtotal WHERE id = {$row['id']}");
  if ($update) {
    echo json_encode(["status" => "success", "message" => "Keranjang diperbarui"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Gagal update keranjang"]);
  }
} else {
  $insert = $conn->query("INSERT INTO cart (user_id, nama_makanan, jumlah_pesanan, harga, pajak, subtotal)
                          VALUES ($user_id, '$nama_makanan', $jumlah, $harga, $ppn, $subtotal)");
  if ($insert) {
    echo json_encode(["status" => "success", "message" => "Item ditambahkan ke keranjang"]);
  } else {
    echo json_encode(["status" => "error", "message" => "Gagal tambah ke keranjang"]);
  }
}
?>
