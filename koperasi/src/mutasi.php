<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

require 'functions.php';

$jumlahDataPerHalaman = 200;
$jumlahData = count(query("SELECT * FROM mutasi"));
$jumlahHalaman = ceil($jumlahData / $jumlahDataPerHalaman);
$halamanAktif = (isset($_GET["halaman"])) ? filter_input(INPUT_GET, 'halaman') : 1;
$awalData = ($jumlahDataPerHalaman * $halamanAktif) - $jumlahDataPerHalaman;
$anggota = query("SELECT * FROM mutasi ORDER BY tanggal LIMIT $awalData, $jumlahDataPerHalaman");

if (isset($_POST["cari"])) {
    $anggota = cariMutasi(filter_input(INPUT_POST, 'keyword'));
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

    <link rel="stylesheet" href="../css/dataAnggota.css">
    <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

    <title>Data Dana Mutasi</title>
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
                    <li class="nav-item active">
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

    <?php
    if (isset($_GET["id"])) {
        $id = filter_input(INPUT_GET, 'id');
        if (hapusMutasi($id) > 0) { ?>
            <div class="alert alert-success" role="alert">
                Data berhasil dihapus.
                <a href="mutasi.php">(Klik disini untuk refresh)</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.href = 'mutasi.php';">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
        <?php
        } else { ?>
            <div class="alert alert-warning" role="alert">
                Data gagal dihapus.
                <a href="mutasi.php">(Klik disini untuk refresh)</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.href = 'mutasi.php';">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
    <?php
        }
    }
    ?>

    <div class="container-fluid float-left">
        <img src="../img/logo_koperasi.png" alt="logo_koperasi" class="float-left logo_koperasi">
        <h2 class="text-center judul">KPRI UNDIP</h2>
        <h4 class="text-center judul">Tabel Data Dana Perubahan</h4>
        <a href="index.php" class="kembali btn btn-secondary ml-2 printInv"><i class="fas fa-arrow-circle-left"> Kembali</i></a>

        <hr>
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <div class="input-group">
                        <input class="form-control" type="text" name="keyword" placeholder="Masukkan keyword pencarian.." autocomplete="off" id="keyword">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text" name="cari" id="tombolCari"><i class="fas fa-search"></i></button>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <a href="formMutasi.php" class="btn btn-success ml-2"><i class="fas fa-plus-circle"> Tambah</i></a>
                    <a href="exportMutasi.php" target="_blank" class="btn btn-warning ml-2"><i class="fas fa-file-excel"> Export</i></a>
                </div>
                <div class="form-group col-md-3 tombolHalaman">
                    <span class="font-weight-light">Halaman : </span>
                    <?php if ($halamanAktif > 1) : ?>
                        <a class="back" href="?halaman=<?= filter_var($halamanAktif) - 1; ?>">&laquo;</a>
                    <?php endif; ?>
                    <?php if ($halamanAktif == 1) {
                        echo '<span class="first invi">First</span>
                        <span class="back invi">&laquo;</span>';
                    } ?>
                    <a class="halamanSekarang" href="?halaman=<?= filter_var($halamanAktif); ?>"><?= filter_var($halamanAktif); ?></a>
                    <?php if ($halamanAktif < $jumlahHalaman) : ?>
                        <a class="next" href="?halaman=<?= filter_var($halamanAktif) + 1; ?>">&raquo;</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>

        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">Tanggal</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Kode</th>
                    <th scope="col">Jumlah</th>
                    <th scope="col" rowspan="2" colspan="2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($halamanAktif == 1) {
                    $i = 1;
                } else {
                    $i = 200 * $halamanAktif - 200 + 1;
                }
                ?>
                <?php foreach ($anggota as $row) : ?>
                    <tr>
                        <th><?= filter_var($i); ?></th>
                        <td><?= filter_var($row["tanggal"]); ?></td>
                        <td><?= filter_var($row["keterangan"]); ?></td>
                        <td><?= filter_var($row["kode"]); ?></td>
                        <?php
                        $angka = $row["jumlah"];
                        $angka_format = number_format($angka, 2, ",", ".");
                        ?>
                        <td>Rp<?= filter_var($angka_format); ?></td>
                        <td><a href="updateMutasi.php?id=<?= filter_var($row["id"]); ?>"><i class=" fas fa-pencil-alt"></i></a></td>
                        <td><a href="mutasi.php?id=<?= filter_var($row["id"]); ?>" onclick="return confirm('Apakah anda yakin menghapus data?');"><i class="fas fa-trash-alt"></i></a></td>
                    </tr>
                    <?php $i++ ?>
                <?php endforeach ?>
            </tbody>
        </table>
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