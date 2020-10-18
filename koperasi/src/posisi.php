<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

if (isset($_POST["masuk"])) {
    $_SESSION["awal"] = filter_input(INPUT_POST, 'awal');
    $_SESSION["akhir"] = filter_input(INPUT_POST, 'akhir');
    header("Location: dataPosisi.php");
    exit;
}
if (isset($_POST["masukBulanan"])) {
    $_SESSION["awalBulan"] = filter_input(INPUT_POST, 'awalBulan');
    $_SESSION["akhirBulan"] = filter_input(INPUT_POST, 'akhirBulan');
    header("Location: dataPosisiBulanan.php");
    exit;
}
if (isset($_POST["masukTahunan"])) {
    $_SESSION["awalTahun"] = filter_input(INPUT_POST, 'awalTahun');
    $_SESSION["akhirTahun"] = filter_input(INPUT_POST, 'akhirTahun');
    header("Location: dataPosisiTahunan.php");
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/posisi.css">
    <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

    <title>Data Posisi Dana Proteksi</title>
</head>

<body class="">
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand text-white-50" href="index.php"><i class="fas fa-home">Dashboard</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Selamat Datang, <?= filter_input(INPUT_SESSION, 'username'); ?><span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-3" href="dataAnggota.php"><i class="fas fa-users"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-1" href="pemasukkan.php"><i class="fas fa-hand-holding-usd"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-1" href="pengeluaran.php"><i class="fas fa-money-bill-wave"></i></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link ml-1" href="mutasi.php"><i class="fas fa-dna"></i></a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link ml-1" href="posisi.php"><i class="fas fa-file-invoice-dollar"></i></a>
                    </li>
                    <?php if (isset($_SESSION["sadmin"])) { ?>
                        <li class="nav-item">
                            <a class="nav-link ml-1" href="fakultas.php"><i class="fas fa-hotel"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ml-1" href="persentase.php"><i class="fas fa-percentage"></i></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link ml-1" href="alumni.php"><i class="fas fa-user-times"></i></a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
            <a href="logout.php" class="btn btn-danger navbar-right"><i class="fas fa-sign-out-alt"> Keluar</i></a>
        </div>
    </nav>

    <div class="container-fluid small">
        <a href="index.php" class="kembali btn btn-secondary ml-2 printInv"><i class="fas fa-arrow-circle-left"> Kembali</i></a>
        <div class="row">
            <div class="col">
                <div class="card mt-3">
                    <div class="card-body">
                        <h3 class="text-center judul">Daftar Dana Proteksi</h3>
                        <hr>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="awal">Tanggal Awal : </label>
                                <input type="date" name="awal" id="awal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="akhir">Tanggal Akhir : </label>
                                <input type="date" name="akhir" id="akhir" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 buttonSimpan float-right" name="masuk">Lanjutkan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mt-3">
                    <div class="card-body">
                        <h3 class="text-center judul">Dana Proteksi Bulanan</h3>
                        <hr>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="awal">Bulan Awal : </label>
                                <input type="date" name="awalBulan" id="awal" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="akhir">Bulan Akhir : </label>
                                <input type="date" name="akhirBulan" id="akhir" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 buttonSimpan float-right" name="masukBulanan">Lanjutkan</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card mt-3">
                    <div class="card-body">
                        <h3 class="text-center judul">Dana Proteksi Tahunan</h3>
                        <hr>
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="awal">Tahun Awal : </label>
                                <input type="number" name="awalTahun" id="awal" class="form-control" required min="0" max="9999" placeholder="Masukkan batas awal tahun disini">
                            </div>
                            <div class="form-group">
                                <label for="akhir">Tahun Akhir : </label>
                                <input type="number" name="akhirTahun" id="akhir" class="form-control" required min="0" max="9999" placeholder="Masukkan batas akhir tahun disini">
                            </div>
                            <button type="submit" class="btn btn-primary mt-2 buttonSimpan float-right" name="masukTahunan">Lanjutkan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>

    <script src="../script/script.js"></script>
</body>

</html>