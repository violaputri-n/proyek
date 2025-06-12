<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['user_id'])) {
    die("Silakan login terlebih dahulu.");
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reservasi Meja</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body {
            background-color: #f5f3ef;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .form-container {
            background-color: #fff9f5;
            border: 1px solid #d2b48c;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(102, 51, 0, 0.2);
        }
        h2 {
            color: #5c3d1d;
        }
        label {
            color: #5c3d1d;
        }
        .btn-success {
            background-color: #8b5e3c;
            border-color: #8b5e3c;
        }
        .btn-success:hover {
            background-color: #6c4428;
            border-color: #6c4428;
        }
        .rekening-info {
            background-color: #fff3e6;
            border: 1px dashed #d2b48c;
            padding: 15px;
            border-radius: 8px;
            color: #5c3d1d;
            margin-bottom: 15px;
        }
    </style>
</head>
<body class="p-4">
<div class="container">
    <h2 class="mb-4 text-center">Form Reservasi Meja</h2>
    <form method="POST" action="simpan_reservasi.php" enctype="multipart/form-data" class="form-container">
        <div class="mb-3">
            <label>Nama Pemesan:</label>
            <input type="text" name="nama_pemesan" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Tanggal:</label>
            <input type="date" name="tanggal" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Waktu:</label>
            <input type="time" name="waktu" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jumlah Orang:</label>
            <input type="number" name="jumlah_orang" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Nomor Meja:</label>
            <input type="number" name="nomor_meja" class="form-control" required>
        </div>

        <!-- DP & Bukti Transfer -->
        <div class="rekening-info">
            <strong>Transfer DP (Min. Rp50.000) ke:</strong><br>
            Bank BCA - 1234567890 a.n. Restoran ABC
        </div>
        <div class="mb-3">
            <label>Upload Bukti Transfer:</label>
            <input type="file" name="bukti_transfer" accept="image/*" class="form-control" required>
        </div>

        <!-- Pesan Makanan -->
        <div class="mb-3">
            <label>Pesan Makanan:</label>
            <select name="opsi_pesan_makanan" class="form-control" onchange="toggleMenu(this.value)">
                <option value="resto">Langsung di Resto</option>
                <option value="web">Pesan via Web</option>
            </select>
        </div>

        <div class="mb-3" id="menu_makanan" style="display: none;">
            <label>Pilih Makanan & Jumlah:</label>
            <div class="row g-2">
                <div class="col-6">
                    <input type="checkbox" name="menu[]" value="Nasi Goreng" id="makanan1" onchange="toggleJumlah(this)">
                    <label for="makanan1">Nasi Goreng</label>
                </div>
                <div class="col-6">
                    <input type="number" name="jumlah[Nasi Goreng]" class="form-control form-control-sm jumlah" min="1" placeholder="Jumlah" style="display:none;">
                </div>

                <div class="col-6">
                    <input type="checkbox" name="menu[]" value="Ayam Bakar" id="makanan2" onchange="toggleJumlah(this)">
                    <label for="makanan2">Ayam Bakar</label>
                </div>
                <div class="col-6">
                    <input type="number" name="jumlah[Ayam Bakar]" class="form-control form-control-sm jumlah" min="1" placeholder="Jumlah" style="display:none;">
                </div>

                <div class="col-6">
                    <input type="checkbox" name="menu[]" value="Sate Ayam" id="makanan3" onchange="toggleJumlah(this)">
                    <label for="makanan3">Sate Ayam</label>
                </div>
                <div class="col-6">
                    <input type="number" name="jumlah[Sate Ayam]" class="form-control form-control-sm jumlah" min="1" placeholder="Jumlah" style="display:none;">
                </div>

                <div class="col-6">
                    <input type="checkbox" name="menu[]" value="Es Teh" id="makanan4" onchange="toggleJumlah(this)">
                    <label for="makanan4">Es Teh</label>
                </div>
                <div class="col-6">
                    <input type="number" name="jumlah[Es Teh]" class="form-control form-control-sm jumlah" min="1" placeholder="Jumlah" style="display:none;">
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success w-100 mt-4">Kirim Reservasi</button>
    </form>
</div>

<script>
function toggleMenu(value) {
    document.getElementById('menu_makanan').style.display = (value === 'web') ? 'block' : 'none';
}

function toggleJumlah(checkbox) {
    const input = checkbox.parentElement.nextElementSibling.querySelector('input');
    if (checkbox.checked) {
        input.style.display = 'block';
        input.required = true;
    } else {
        input.style.display = 'none';
        input.required = false;
        input.value = '';
    }
}
</script>
</body>
</html>
