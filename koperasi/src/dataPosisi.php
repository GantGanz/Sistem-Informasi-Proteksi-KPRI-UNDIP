<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION["awal"])) {
    if (!isset($_SESSION["akhir"])) {
        header("Location: posisi.php");
        exit;
    }
}

require 'functions.php';

$namaBulan = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");

$awal = $_SESSION["awal"];
$akhir = $_SESSION["akhir"];

$unionPemasukan = query("(SELECT awal AS tanggal, nama AS nama, nominal_akhir AS jumlah FROM pemasukan WHERE awal >= '$awal' AND awal <= '$akhir')
                        UNION
                        (SELECT tanggal AS tanggal, keterangan AS nama, jumlah AS jumlah FROM mutasi WHERE tanggal >= '$awal' AND tanggal <= '$akhir' AND kode = 'Debit') ORDER BY tanggal");
$unionPengeluaran = query("(SELECT tgl_cair AS tanggal, nama AS nama, nominal_cair AS jumlah FROM pengeluaran WHERE tgl_cair >= '$awal' AND tgl_cair <= '$akhir')
                        UNION
                        (SELECT tanggal AS tanggal, keterangan AS nama, jumlah AS jumlah FROM mutasi WHERE tanggal >= '$awal' AND tanggal <= '$akhir' AND kode = 'Kredit') ORDER BY tanggal");

$saldo = query("SELECT nominal FROM saldo");
$mutasiKredit = query("SELECT * FROM mutasi WHERE tanggal < '$awal' AND kode = 'Kredit' ORDER BY tanggal");
$mutasiDebit = query("SELECT * FROM mutasi WHERE tanggal < '$awal' AND kode = 'Debit' ORDER BY tanggal");
$pemasukkanSaldo = query("SELECT * FROM pemasukan WHERE awal < '$awal' ORDER BY awal");
$pengeluaranSaldo = query("SELECT * FROM pengeluaran WHERE tgl_cair < '$awal' ORDER BY tgl_cair");

$pemasukkanSaldoSum = 0;
$pengeluaranSaldoSum = 0;
$mutasiDebitSum = 0;
$mutasiKreditSum = 0;

foreach ($pemasukkanSaldo as $row) {
    $pemasukkanSaldoSum = $pemasukkanSaldoSum + $row['nominal_akhir'];
}
foreach ($pengeluaranSaldo as $row) {
    $pengeluaranSaldoSum = $pengeluaranSaldoSum + $row['nominal_cair'];
}
foreach ($mutasiDebit as $row) {
    $mutasiDebitSum = $mutasiDebitSum + $row['jumlah'];
}
foreach ($mutasiKredit as $row) {
    $mutasiKreditSum = $mutasiKreditSum + $row['jumlah'];
}
foreach ($saldo as $row) {
    $saldo = $row['nominal'];
}

$saldoAwal = $saldo + $pemasukkanSaldoSum - $pengeluaranSaldoSum - $mutasiKreditSum + $mutasiDebitSum;
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <link rel="stylesheet" href="../css/pengeluaran.css">
    <script src="https://kit.fontawesome.com/8306e7b683.js" crossorigin="anonymous"></script>

    <style>
        .printShow {
            display: none;
        }

        @media print {
            .printInv {
                display: none;
            }

            .printShow {
                display: block;
            }
        }
    </style>
    <title>Dana Proteksi Periode Tertentu</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand text-white-50" href="index.php"><i class="fas fa-home">Dashboard</i></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item active">
                        <a class="nav-link" href="#">Selamat Datang, <?= $_SESSION["username"]; ?><span class="sr-only">(current)</span></a>
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

    <?php
    if (isset($_GET["id"])) {
        $id = $_GET["id"];
        if (hapus($id) > 0) { ?>
            <div class="alert alert-success" role="alert">
                Data berhasil dihapus.
                <a href="dataAnggota.php">(Klik disini untuk refresh)</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.href = 'dataAnggota.php';">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
        <?php
        } else { ?>
            <div class="alert alert-warning" role="alert">
                Data gagal dihapus.
                <a href="dataAnggota.php">(Klik disini untuk refresh)</a>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close" onclick="window.location.href = 'dataAnggota.php';">
                    <span aria-hidden="true">&times</span>
                </button>
            </div>
    <?php
        }
    }
    ?>

    <div class="container-fluid">
        <img src="../img/logo_koperasi.png" alt="logo_koperasi" class="float-left logo_koperasi">
        <h2 class="text-center judul">KPRI UNDIP</h2>
        <h4 class="text-center judul">Laporan Dana Proteksi</h4>
        <a href="posisi.php" class="kembali btn btn-secondary ml-2 printInv"><i class="fas fa-arrow-circle-left"> Kembali</i></a>
        <hr>
        <form action="" method="POST">
            <div class="form-row">
                <div class="form-group col-md-6 mt-1">
                    <h5>Dari tanggal : <a href="posisi.php"><?= $awal; ?></a>, sampai dengan : <a href="posisi.php"><?= $akhir; ?></a></h5>
                </div>
                <div class="form-group col-md-6 printInv">
                    <!-- <a href="exportPosisi.php" target="_blank" class="printInv btn btn-success mr-3"><i class="fas fa-file-excel"> Export</i></a> -->
                    <button onclick="window.print()" class="printInv btn btn-info"><i class="fas fa-print"> Print</i></button>
                </div>
            </div>
        </form>

        <div class="row bg-white border">
            <?php
            $totalPemasukan = 0;
            $totalPengeluaran = 0;
            ?>
            <table class="table table-striped table-bordered table-sm col-md-6">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" colspan="3">Pemasukkan</th>
                    </tr>
                    <tr>
                        <th scope="col" style="width: 90px">Tanggal</th>
                        <th scope="col" style="width: 260px">Nama</th>
                        <th scope="col" style="width: 150px">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $negativS = false;
                    if ($saldoAwal < 0) {
                        $negativS = true;
                    }
                    $saldo_awal_format = number_format(abs($saldoAwal), 2, ",", "."); ?>
                    <tr>
                        <th><?= $awal; ?></th>
                        <th>Saldo Awal : </th>
                        <th><?php echo $negativS ? '-' : ''; ?>Rp<?= $saldo_awal_format; ?></th>
                    </tr>
                    <?php foreach ($unionPemasukan as $row) : ?>
                        <tr>
                            <td><?= $row["tanggal"]; ?></td>
                            <td><?= $row["nama"]; ?></td>
                            <?php
                            $angka = $row["jumlah"];
                            $totalPemasukan = $totalPemasukan + $angka;
                            $angka_format = number_format($angka, 2, ",", ".");
                            ?>
                            <td>Rp<?= $angka_format; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <table class="table table-striped table-bordered table-sm col-md-6">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" colspan="3">Pengeluaran</th>
                    </tr>
                    <tr>
                        <th scope="col" style="width: 90px">Tanggal</th>
                        <th scope="col" style="width: 260px">Nama</th>
                        <th scope="col" style="width: 150px">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($unionPengeluaran as $row) : ?>
                        <tr>
                            <td><?= $row["tanggal"]; ?></td>
                            <td><?= $row["nama"]; ?></td>
                            <?php
                            $angka = $row["jumlah"];
                            $totalPengeluaran = $totalPengeluaran + $angka;
                            $angka_format = number_format($angka, 2, ",", ".");
                            ?>
                            <td>Rp<?= $angka_format; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <table class="table table-striped table-bordered table-sm tabel_bawah printShow" style="margin-top: -2.2%;">
                <tbody>
                    <?php
                    $total = $saldoAwal + $totalPemasukan;
                    $angka_format = number_format($total, 2, ",", ".");
                    $negativ = false;
                    $negativSA = false;
                    $saldoAkhir = $total - $totalPengeluaran;
                    if ($saldoAkhir < 0) {
                        $negativSA = true;
                    }
                    $saldo_akhir_format = number_format(abs($saldoAkhir), 2, ",", ".");
                    ?>
                    <tr>
                        <td style="width: 95px"></td>
                        <td style="width: 270px"></td>
                        <td style="width: 155px"></td>
                        <td style="width: 95px"></td>
                        <th style="width: 270px">Saldo : </th>
                        <th style="width: 155px"><?php echo $negativSA ? '-' : ''; ?>Rp<?= $saldo_akhir_format; ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= $angka_format; ?></th>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= $angka_format; ?></th>
                    </tr>
                </tbody>
            </table>

            <table class="table table-striped table-bordered table-sm tabel_bawah printInv">
                <tbody>
                    <?php
                    $total = $saldoAwal + $totalPemasukan;
                    $angka_format = number_format($total, 2, ",", ".");
                    $negativ = false;
                    $negativSA = false;
                    $saldoAkhir = $total - $totalPengeluaran;
                    if ($saldoAkhir < 0) {
                        $negativSA = true;
                    }
                    $saldo_akhir_format = number_format(abs($saldoAkhir), 2, ",", ".");
                    ?>
                    <tr>
                        <td style="width: 90px"></td>
                        <td style="width: 260px"></td>
                        <td style="width: 150px"></td>
                        <td style="width: 90px"></td>
                        <th style="width: 260px">Saldo : </th>
                        <th style="width: 150px"><?php echo $negativSA ? '-' : ''; ?>Rp<?= $saldo_akhir_format; ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= $angka_format; ?></th>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= $angka_format; ?></th>
                    </tr>
                </tbody>
            </table>
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

<!-- id, nama, tempat_lahir, tanggal_lahir, fakultas, rt, rw, desa, kecamatan, kabupaten, provinsi, nip, no_anggota, no_hp, awal, nominal, akhir -->
<!-- // $angka_format = number_format($totalPengeluaran, 2, ",", ".");
// $saldo_akhir = $saldo["nominal"] + $jumlah;
// if ($saldo_akhir < 0) { // $negativ2=true; // } // $saldo_format=number_format(abs($saldo_akhir), 2, "," , "." ); <p>Saldo Sekarang : <span class="invi">12345678901234</span> <?php echo $negativ2 ? '-' : ''; ?>Rp<?= $saldo_format; ?></p> -->