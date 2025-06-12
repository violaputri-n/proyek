<?php
$conn = mysqli_connect("localhost", "root", "", "uaspw");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kritik & Saran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            background-color: #343a40;
            height: 100vh;
            padding-top: 20px;
            position: fixed;
            width: 220px;
        }
        .sidebar a {
            color: white;
            padding: 10px 20px;
            display: block;
            text-decoration: none;
        }
        .sidebar a:hover, .sidebar a.active {
            background-color: #495057;
            border-radius: 4px;
        }
        .content {
            margin-left: 230px;
            padding: 30px;
        }
        .kritik-box {
            background: white;
            border-left: 4px solid #a47148;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
        }
        .kritik-nama {
            font-weight: 600;
            color: #5b3924;
        }
        .kritik-tanggal {
            color: #888;
            font-size: 13px;
        }
        .pagination a.active {
            background-color: #a47148 !important;
            border-color: #a47148 !important;
            color: white !important;
        }
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar">
        <h4 class="text-center text-white mb-3">Admin Panel</h4>
        <a href="dataadmin.php">Dashboard</a>
        <a href="kelola_makanan.php">Kelola Makanan</a>
        <a href="lihat_pesanan.php">Lihat Pesanan</a>
        <a href="pengguna.php">Pengguna</a>
        <a href="isi_kritiksaran.php" class="active">Kritik & Saran</a>
        <a href="logout.php" class="mt-auto border-top pt-2">Logout</a>
    </div>

    <!-- Main Content -->
    <div class="content w-100">
        <h2 class="mb-4">Daftar Kritik & Saran</h2>

        <!-- Search Form -->
        <form method="GET" class="input-group mb-4 w-50">
            <input type="text" name="search" class="form-control" placeholder="Cari kritik atau saran..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
            <button class="btn btn-outline-secondary" type="submit">Cari</button>
        </form>

        <?php
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($page - 1) * $limit;

        $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
        $search_condition = '';
        if (!empty($search)) {
            $search_condition = " WHERE (nama LIKE '%$search%' OR email LIKE '%$search%' OR isi_kritiksaran LIKE '%$search%')";
        }

        $count_query = "SELECT COUNT(*) as total FROM kritik_saran" . $search_condition;
        $count_result = mysqli_query($conn, $count_query);
        $total_data = mysqli_fetch_assoc($count_result)['total'];
        $total_pages = ceil($total_data / $limit);

        $query = "SELECT * FROM kritik_saran" . $search_condition . " ORDER BY tanggal_submit DESC LIMIT $limit OFFSET $offset";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<div class="kritik-box">';
                echo '<div class="d-flex justify-content-between">';
                echo '<div class="kritik-nama">' . htmlspecialchars($row['nama']) . (!empty($row['email']) && $row['nama'] != 'Anonim' ? ' <small class="text-muted">&lt;' . htmlspecialchars($row['email']) . '&gt;</small>' : '') . '</div>';
                echo '<div class="kritik-tanggal">' . date('d F Y H:i', strtotime($row['tanggal_submit'])) . '</div>';
                echo '</div>';
                echo '<div class="mt-2">' . nl2br(htmlspecialchars($row['isi_kritiksaran'])) . '</div>';
                echo '</div>';
            }

            // Pagination
            if ($total_pages > 1) {
                echo '<nav><ul class="pagination">';
                if ($page > 1) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . (empty($search) ? '' : '&search=' . urlencode($search)) . '">&laquo;</a></li>';
                }
                for ($i = 1; $i <= $total_pages; $i++) {
                    $active = $i == $page ? ' active' : '';
                    echo '<li class="page-item' . $active . '"><a class="page-link" href="?page=' . $i . (empty($search) ? '' : '&search=' . urlencode($search)) . '">' . $i . '</a></li>';
                }
                if ($page < $total_pages) {
                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . (empty($search) ? '' : '&search=' . urlencode($search)) . '">&raquo;</a></li>';
                }
                echo '</ul></nav>';
            }
        } else {
            echo '<p class="text-muted">Tidak ada kritik dan saran yang ditemukan.</p>';
        }

        mysqli_close($conn);
        ?>
    </div>
</div>

</body>
</html>
