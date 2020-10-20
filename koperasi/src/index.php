<?php
session_start();
if (true != filter_var($_SESSION["login"])) {
    header("Location: login.php");
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

    <link rel="stylesheet" href="../css/dashboard.css">
    <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

    <title>Dashboard</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-home">Dashboard</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Selamat Datang, <?= filter_var($_SESSION["username"]); ?><span class="sr-only">(current)</span></a>
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
                    <li class="nav-item">
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
        <div class="row">
            <div class="col">
                <div class="card border-success h-100" onclick="location.href='dataAnggota.php'">
                    <img src="../img/users-solid.png" class="card-img-top mx-auto gambarkartu" alt="Gambar orang-orang">
                    <div class="card-body">
                        <h5 class="card-title text-center">Entry Data Anggota</h5>
                        <p class="card-text text-justify">Menampilkan, menambah, meremajakan, menghapus, atau meng-ekspor data dari
                            anggota yang melakukan kredit.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-warning h-100" onclick="location.href='pemasukkan.php'">
                    <img src="../img/money-get.png" class="card-img-top mx-auto gambarkartu" alt="Gambar menerima uang">
                    <div class="card-body">
                        <h5 class="card-title text-center">Entry Pemasukan Dana Proteksi</h5>
                        <p class="card-text text-justify">Menampilkan, menambah, meremajakan, menghapus, atau meng-ekspor data pemasukan
                            dana proteksi. Serta menampilkan dan mencetak proteksi yang masih berlaku maupun tidak</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-danger h-100" onclick="location.href='pengeluaran.php'">
                    <img src="../img/money-bill.png" class="card-img-top mx-auto gambarkartu" alt="Gambar uang melayang">
                    <div class="card-body">
                        <h5 class="card-title text-center">Entry Pengeluaran Dana Proteksi</h5>
                        <p class="card-text text-justify">Menampilkan, menambah, meremajakan, menghapus, atau meng-ekspor data
                            pengeluaran dana proteksi.</p>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card border-primary h-100" onclick="location.href='mutasi.php'">
                    <img src="../img/dna-solid.png" class="card-img-top mx-auto gambarkartu" alt="Gambar mutasi">
                    <div class="card-body">
                        <h5 class="card-title text-center">Entry Data Dana Perubahan</h5>
                        <p class="card-text text-justify">Menampilkan, menambah, meremajakan, menghapus, atau meng-ekspor data dana mutasi.</p>
                    </div>
                </div>
            </div>
            <div class="col ">
                <div class="card border-info h-100" onclick="location.href='posisi.php'">
                    <img src="../img/file-invoice-dollar.png" class="card-img-top mx-auto gambarkartu" alt="Gambar uang difile">
                    <div class="card-body">
                        <h5 class="card-title text-center">Laporan Dana Proteksi</h5>
                        <p class="card-text text-justify">Menampilkan atau mencetak laporan data dana proteksi dari periode yang diinginkan baik harian, bulanan, ataupun tahunan.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container small">
        <?php if (isset($_SESSION["sadmin"])) { ?>
            <hr>
            <div class="text-center">
                <h5>Fitur Tambahan untuk Super Admin</h5>
            </div>
            <div class="card-deck mx-auto mt-3">
                <div class="card border-dark" onclick="location.href='fakultas.php'">
                    <img src="../img/hotel-solid.png" class="card-img-top mx-auto gambarkartu" alt="Gambar fakultas">
                    <div class="card-body">
                        <h5 class="card-title text-center">Setting Data Fakultas</h5>
                        <p class="card-text text-justify">Menampilkan, menambah, meremajakan, atau menghapus data Unit Fakultas.</p>
                    </div>
                </div>
                <div class="card border-info" onclick="location.href='persentase.php'">
                    <img src="../img/percentage-solid.png" class="card-img-top mx-auto gambarkartu" alt="Gambar persen">
                    <div class="card-body">
                        <h5 class="card-title text-center">Setting Persentase Proteksi</h5>
                        <p class="card-text text-justify">Menampilkan, menambah, meremajakan, atau menghapus data Persentase Proteksi.</p>
                    </div>
                </div>
                <div class="card border-secondary" onclick="location.href='alumni.php'">
                    <img src="../img/user-times-solid.png" class="card-img-top mx-auto gambarkartu" alt="Gambar orang x">
                    <div class="card-body">
                        <h5 class="card-title text-center">Alumni Anggota</h5>
                        <p class="card-text text-justify">Menampilkan data dari alumni yang dulunya merupakan anggota.</p>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
    <br>
    <br>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
</body>

</html>