<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}

$user_id     = $_SESSION['user_id'];
$nama        = $_POST['nama_pemesan'];
$tanggal     = $_POST['tanggal'];
$waktu       = $_POST['waktu'];
$jumlah      = $_POST['jumlah_orang'];
$meja        = $_POST['nomor_meja'];
$opsi_pesan  = $_POST['opsi_pesan_makanan'] ?? '';

// Ambil menu & jumlahnya
$menu         = isset($_POST['menu']) ? $_POST['menu'] : [];
$jumlah_menu  = isset($_POST['jumlah']) ? $_POST['jumlah'] : [];

$menu_json    = json_encode($menu);
$jumlah_json  = json_encode($jumlah_menu);

// Upload file bukti transfer
$bukti_path = null;
if (isset($_FILES['bukti_transfer']) && $_FILES['bukti_transfer']['error'] == 0) {
    $ext      = pathinfo($_FILES['bukti_transfer']['name'], PATHINFO_EXTENSION);
    $filename = uniqid('bukti_') . '.' . $ext;
    $tujuan   = 'uploads/' . $filename;

    if (move_uploaded_file($_FILES['bukti_transfer']['tmp_name'], $tujuan)) {
        $bukti_path = $filename;
    } else {
        die("Gagal mengupload file.");
    }
}

// Simpan ke database
$sql = "INSERT INTO reservasi 
        (user_id, nama_pemesan, tanggal, waktu, jumlah_orang, nomor_meja, bukti_transfer, opsi_pesan_makanan, menu, jumlah_menu)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isssiissss", $user_id, $nama, $tanggal, $waktu, $jumlah, $meja, $bukti_path, $opsi_pesan, $menu_json, $jumlah_json);

if ($stmt->execute()) {
    $_SESSION['last_reservasi_id'] = $conn->insert_id; // Tambahkan ini agar sukses_reservasi.php tahu ID-nya
    header("Location: sukses_reservasi.php");
    exit;
} else {
    echo "Terjadi kesalahan: " . $stmt->error;
}
?>
