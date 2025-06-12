<?php
session_start();
$loggedIn = isset($_SESSION['user_id']);
?>


<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>RAMBU RESTO</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oleo+Script:wght@400;700&family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .navbar-brand img {
            border-radius: 12px;
        }

        .navbar-nav .nav-link {
            font-weight: 600;
            margin: 0 10px;
        }

        .carousel-caption h1, .carousel-caption p {
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.6);
        }

        .card {
            margin: 1rem auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
        }

        .card-img-top {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 15rem;
            object-fit: cover;
        }

        .card-body h5 {
            font-weight: 700;
        }

        #about img {
            border-radius: 15px;
            object-fit: cover;
        }

        #contact h1 {
            font-size: 20px;
        }

        #contact i {
            font-size: 1.5rem;
        }

        .footer p {
            margin-bottom: 0.5rem;
        }
    </style>
</head>

<body>

    <div style="position: fixed; top: 20px; right: 20px; z-index: 999;">
  <a href="cart.html" style="position: relative; display: inline-block; text-decoration: none;">
    🛒
    <span id="cart-count" style="
      position: absolute;
      top: -10px;
      right: -10px;
      background: red;
      color: white;
      border-radius: 50%;
      padding: 2px 6px;
      font-size: 12px;">0</span>
  </a>
</div>

<nav class="navbar navbar-expand-lg fixed-top" style="background-color: #6F4E37;">
  <div class="container">
    <a class="navbar-brand" href="#">
      <img src="img/rrResto.png" height="45" alt="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
<ul class="navbar-nav mx-auto">
  <li class="nav-item"><a class="nav-link text-white" href="index.php">HOME</a></li>
  <li class="nav-item"><a class="nav-link text-white" href="#about">ABOUT</a></li>
  <li class="nav-item"><a class="nav-link text-white" href="#contact">CONTACT</a></li>
  <li class="nav-item"><a class="nav-link text-white" href="menu.html">MENU</a></li>
  <li class="nav-item"><a class="nav-link text-white" href="product.html">DESCRIPTION</a></li>
  <li class="nav-item"><a class="nav-link text-white" href="reservasi.php">RESERVASI</a></li>
</ul>

      <?php if ($loggedIn): ?>
        <div class="d-flex align-items-center gap-2">
          <span class="text-white fw-bold">Halo, <?= htmlspecialchars($_SESSION['user_nama']) ?></span>
          <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>
      <?php else: ?>
        <div class="d-flex gap-2">
          <a href="login.php" class="btn btn-outline-light">Login</a>
          <a href="register.php" class="btn btn-warning text-dark fw-bold">Register</a>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>


    <div id="carouselExampleCaptions" class="carousel slide mt-5">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/Ramburesto-sampul.jpg" class="d-block w-100" alt="..." style="height: 50rem; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">"MAKANAN UNIK KHAS RAMBU RESTO"</h1>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/sambara 3.jpeg" class="d-block w-100" alt="..." style="height: 50rem; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">RAMBU RESTO</h1>
                    <p>INOVASI DALAM SAJIANNYA DAN RASA YANG TAK TERLUPAKAN</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="img/samba2-transformed.png" class="d-block w-100" alt="..." style="height: 50rem; object-fit: cover;">
                <div class="carousel-caption d-none d-md-block">
                    <h1 class="display-4">RAMBU RESTO</h1>
                    <p>KELEZATAN YANG MENGUNDANG EKSPLORASI!!!</p>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="container mt-5">
        <h2 class="text-center mb-4 fw-bold">BEST SELLER</h2>
        <div class="row justify-content-center">
            <div class="col-md-3">
                <div class="card">
                    <img src="img/IMG_20241017_150649.jpg" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">SATE AYAM</h5>
                        <p class="card-text">Sate madura dengan bumbu khas yg kaya akan rempah</p>
                        <a href="pesan.html?menu=Sate%20ayam%20&harga=40000" class="btn btn-primary">RP.40.000</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/liwetfix2.jfif" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">SEGO KATROL</h5>
                        <p class="card-text">Sego liwet dengan rasa gurih dan pedas dari ikan peda</p>
                        <a href="product.html" class="btn btn-primary">Hargae</a>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card">
                    <img src="img/liwetfix3.jfif" class="card-img-top" alt="...">
                    <div class="card-body text-center">
                        <h5 class="card-title">AYAM TANGKAP</h5>
                        <p class="card-text">Sego liwet dengan rasa gurih dan pedas dari ikan peda</p>
                        <a href="product.html" class="btn btn-primary">Hargae</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="about" class="container-fluid mt-5 py-5" style="background-color: #8f847e; color: white;">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="img/Ayam-Pop.webp" class="w-100" style="height: 50vh;">
                </div>
                <div class="col-md-6 d-flex align-items-center">
                    <p class="fs-5">AYAM POP adalah salah satu masakan khas Sumatera Barat yang berbahan dasar ayam. Dibedakan dari ayam goreng biasa karena warnanya yang putih pucat dan direbus dalam air kelapa serta bawang putih sebelum digoreng ringan. Disajikan dengan sambal lado tomat dan sayur daun singkong rebus.</p>
                </div>
            </div>
        </div>
    </div>

<div id="contact" class="container-fluid mt-5 py-5">
    <div class="row">
        <div class="col-md-4">
            <img src="img/cndol durian.webp" alt="" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="col-md-4">
            <img src="img/samba2-transformed.png" alt="" class="w-100 h-100 object-fit-cover">
        </div>
        <div class="col-md-4 d-flex flex-column justify-content-center align-items-center">
            <h2 class="text-center mb-3">CONTACT</h2>
            <p class="text-center">Kami menerima reservasi meja dan juga melayani untuk berbagai acara. Hubungi admin kami melalui telepon atau whatsapp untuk informasi lebih jelasnya.</p>
            <ul class="list-unstyled d-flex flex-column align-items-center gap-2">
                <li><a href="https://www.instagram.com/sajian_sambara" class="text-dark"><i class="fab fa-instagram"></i> Instagram</a></li>
                <li><a href="https://www.tiktok.com/@sambaraalamsutera" class="text-dark"><i class="fab fa-tiktok"></i> TikTok</a></li>
                <li><a href="https://www.youtube.com/watch?v=MvTMXoyP_f4" class="text-dark"><i class="fab fa-youtube"></i> YouTube</a></li>
                <li><a href="https://m.facebook.com/newsajiansambara/" class="text-dark"><i class="fab fa-facebook"></i> Facebook</a></li>
            </ul>

            <a href="input_kritiksaran.php" class="btn btn-outline-dark mt-3 fw-semibold">
                <i class="fas fa-comment-dots me-2"></i> Kritik & Saran
            </a>
        </div>
    </div>
</div>

    <div class="col-md-12">
        <img src="img/resto.jpg" alt="" class="w-100" style="height: 90vh; object-fit: cover;">
    </div>

    <footer class="footer" style="background-color: #6F4E37; color: white;">
        <div class="container py-4">
            <div class="row">
                <div class="col-md-4">
                    <img src="img/rrResto.png" class="w-75">
                </div>
                <div class="col-md-5 text-center">
                    <p>Perumahan,<br>Jl. Rambu Raden Gunawan,<br>Kepayang, Rajabasa, Bandar Lampung</p>
                    <p>Buka: Senin - Minggu<br>Jam: 10.00 - 22.00</p>
                    <p>(022) 20456465<br>info@restorambu.com</p>
                </div>
                <div class="col-md-3 text-end">
                    <small>&copy; 2024 restorambu.com</small>
                </div>
            </div>
        </div>
    </footer>
</body>

</html>