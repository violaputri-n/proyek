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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Kritik & Saran</title>
    <link href="https://fonts.googleapis.com/css2?family=Georgia&family=Open+Sans&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f5f0ea;
            margin: 0;
            padding: 40px 20px;
            color: #3e2f20;
        }

        .container {
            max-width: 650px;
            margin: 0 auto;
            background: #fff8f0;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            border: 2px solid #a47148;
        }

        h1 {
            text-align: center;
            font-family: 'Georgia', serif;
            font-size: 32px;
            color: #5b3924;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #5b3924;
        }

        input[type="text"],
        input[type="email"],
        textarea {
            width: 100%;
            padding: 12px;
            border: 1.5px solid #c5a27a;
            border-radius: 6px;
            box-sizing: border-box;
            background-color: #fffdf9;
            color: #3e2f20;
        }

        textarea {
            height: 140px;
        }

        button {
            background-color: #a47148;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #8d5e36;
        }

        input[type="checkbox"] {
            transform: scale(1.2);
            margin-right: 8px;
        }

        .message {
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 6px;
            font-weight: bold;
        }

        .success {
            background-color: #e9f7ef;
            color: #2e7d32;
            border: 1px solid #a5d6a7;
        }

        .error {
            background-color: #fdecea;
            color: #c62828;
            border: 1px solid #ef9a9a;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Form Kritik & Saran</h1>

        <?php if (isset($_GET['status'])): ?>
            <div class="message <?php echo $_GET['status'] === 'success' ? 'success' : 'error'; ?>">
                <?php 
                echo $_GET['status'] === 'success' 
                    ? "Terima kasih! Kritik dan saran Anda telah kami terima." 
                    : "Maaf, terjadi kesalahan. Silakan coba lagi.";
                ?>
            </div>
        <?php endif; ?>

        <form action="proses_kritiksaran.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama (Opsional):</label>
                <input type="text" id="nama" name="nama" placeholder="Nama Anda">
            </div>

            <div class="form-group">
                <label for="email">Email (Opsional):</label>
                <input type="email" id="email" name="email" placeholder="Email Anda">
            </div>

            <div class="form-group">
                <label for="kritiksaran">Kritik/Saran:</label>
                <textarea id="kritiksaran" name="kritiksaran" required placeholder="Tuliskan kritik dan saran Anda di sini..."></textarea>
            </div>

            <div class="form-group">
                <input type="checkbox" id="anonim" name="anonim" value="1">
                <label for="anonim" style="display: inline;">Kirim sebagai anonim</label>
            </div>

            <button type="submit">Kirim Kritik/Saran</button>
        </form>
    </div>
</body>
</html>
