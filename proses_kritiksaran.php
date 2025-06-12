<?php
$conn = mysqli_connect("localhost", "root", "", "uaspw");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$nama = isset($_POST['anonim']) ? 'Anonim' : $_POST['nama'];
$email = isset($_POST['anonim']) ? '' : $_POST['email'];
$kritiksaran = $_POST['kritiksaran'];
$is_anonim = isset($_POST['anonim']) ? 1 : 0;

$sql = "INSERT INTO kritik_saran (nama, email, isi_kritiksaran, is_anonim, tanggal_submit)
        VALUES (?, ?, ?, ?, NOW())";

$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "sssi", $nama, $email, $kritiksaran, $is_anonim);

if (mysqli_stmt_execute($stmt)) {
    header("Location: input_kritiksaran.php?status=success");
} else {
    header("Location: input_kritiksaran.php?status=error");
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
