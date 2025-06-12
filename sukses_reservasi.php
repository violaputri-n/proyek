<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['last_reservasi_id'])) {
    die("Reservasi tidak ditemukan.");
}

$id = (int) $_SESSION['last_reservasi_id'];
$query = $conn->prepare("SELECT * FROM reservasi WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    die("Data reservasi tidak ditemukan.");
}

$res = $result->fetch_assoc();
$menus = json_decode($res['menu'], true);
$jumlahs = json_decode($res['jumlah_menu'], true);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Reservasi Berhasil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fdfaf6;
            font-family: 'Segoe UI', sans-serif;
        }
        .card {
            background-color: #fff8f0;
            border: 1px solid #d2b48c;
        }
        .btn-coklat {
            background-color: #8b5e3c;
            color: white;
        }
        .btn-coklat:hover {
            background-color: #70432a;
        }
        .judul {
            color: #8b5e3c;
        }
    </style>
</head>
<body class="p-4">
<div class="container text-center">
    <h1 class="judul mb-3">Reservasi Berhasil!</h1>
    <p class="lead">Terima kasih telah melakukan reservasi di <strong>Rambu Resto</strong>.</p>

    <div class="card shadow p-4 my-4 mx-auto" style="max-width: 600px;">
        <h5 class="text-center">Detail Reservasi</h5>
        <hr>
        <ul class="list-group text-start mb-3">
            <li class="list-group-item"><strong>ID:</strong> #<?= $res['id'] ?></li>
            <li class="list-group-item"><strong>Nama:</strong> <?= htmlspecialchars($res['nama_pemesan']) ?></li>
            <li class="list-group-item"><strong>Tanggal:</strong> <?= $res['tanggal'] ?></li>
            <li class="list-group-item"><strong>Waktu:</strong> <?= $res['waktu'] ?></li>
            <li class="list-group-item"><strong>Jumlah Orang:</strong> <?= $res['jumlah_orang'] ?></li>
            <li class="list-group-item"><strong>Nomor Meja:</strong> <?= $res['nomor_meja'] ?></li>
            <?php if (!empty($menus)): ?>
                <li class="list-group-item">
                    <strong>Menu Dipesan:</strong>
                    <ul class="mb-0">
                        <?php foreach ($menus as $i => $m): ?>
                            <li><?= htmlspecialchars($m) ?> x <?= htmlspecialchars($jumlahs[$i] ?? 0) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </li>
            <?php endif; ?>
            <?php if (!empty($res['bukti_transfer'])): ?>
                <li class="list-group-item">
                    <strong>Bukti Transfer:</strong><br>
                    <img src="uploads/<?= htmlspecialchars($res['bukti_transfer']) ?>" alt="Bukti Transfer" class="img-fluid rounded shadow-sm mt-2">
                </li>
            <?php endif; ?>
        </ul>
        <a href="index.php" class="btn btn-coklat mt-3">Kembali ke Beranda</a>
    </div>
</div>
</body>
</html>
