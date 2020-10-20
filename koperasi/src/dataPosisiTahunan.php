<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
if (!isset($_SESSION["awalTahun"])) {
    if (!isset($_SESSION["akhirTahun"])) {
        header("Location: posisi.php");
        exit;
    }
}

require 'functions.php';

$awal = $_SESSION["awalTahun"];
$akhir = $_SESSION["akhirTahun"];

$unionPemasukan = query("(SELECT awal AS tanggal, nama AS nama, nominal_akhir AS jumlah FROM pemasukan WHERE YEAR(awal) >= '$awal' AND YEAR(awal) <= '$akhir')
                        UNION
                        (SELECT tanggal AS tanggal, keterangan AS nama, jumlah AS jumlah FROM mutasi WHERE YEAR(tanggal) >= '$awal' AND YEAR(tanggal) <= '$akhir' AND kode = 'Debit') ORDER BY tanggal");
$unionPengeluaran = query("(SELECT tgl_cair AS tanggal, nama AS nama, nominal_cair AS jumlah FROM pengeluaran WHERE YEAR(tgl_cair) >= '$awal' AND YEAR(tgl_cair) <= '$akhir')
                        UNION
                        (SELECT tanggal AS tanggal, keterangan AS nama, jumlah AS jumlah FROM mutasi WHERE YEAR(tanggal) >= '$awal' AND YEAR(tanggal) <= '$akhir' AND kode = 'Kredit') ORDER BY tanggal");

$saldo = query("SELECT nominal FROM saldo");
$mutasiKredit = query("SELECT * FROM mutasi WHERE YEAR(tanggal) < '$awal' AND kode = 'Kredit' ORDER BY tanggal");
$mutasiDebit = query("SELECT * FROM mutasi WHERE YEAR(tanggal) < '$awal' AND kode = 'Debit' ORDER BY tanggal");
$pemasukkanSaldo = query("SELECT * FROM pemasukan WHERE YEAR(awal) < '$awal' ORDER BY awal");
$pengeluaranSaldo = query("SELECT * FROM pengeluaran WHERE YEAR(tgl_cair) < '$awal' ORDER BY tgl_cair");

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
                    <li class="nav-item active">
                        <a class="nav-link ml-1" href="posisi.php"><i class="fas fa-file-invoice-dollar"></i></a>
                    </li>
                    <?php if (true == (filter_var($_SESSION["sadmin"]))) { ?>
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
                    <h5>Dari Tahun : <a href="posisi.php"><?= filter_var($awal); ?></a>, sampai dengan : <a href="posisi.php"><?= filter_var($akhir); ?></a></h5>
                </div>
                <div class="form-group col-md-6 printInv">
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
                        <th scope="col" style="width: 90px">No.</th>
                        <th scope="col" style="width: 260px">Tahun</th>
                        <th scope="col" style="width: 150px">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    $angka_format = '0,00';
                    $tahunNow = null;
                    $pemasukanTahunan = 0;
                    $jumlahSementara = 0;
                    $satu = 0;
                    $x = 1;
                    $negativS = false;
                    if ($saldoAwal < 0) {
                        $negativS = true;
                    }
                    $saldo_awal_format = number_format(abs($saldoAwal), 2, ",", ".");
                    ?>
                    <tr>
                        <td></td>
                        <th class="text-center">Saldo Awal : </th>
                        <th><?php echo $negativS ? '-' : ''; ?>Rp<?= filter_var($saldo_awal_format); ?></th>
                    </tr>
                    <?php foreach ($unionPemasukan as $row) : ?>
                        <?php
                        if ($tahunNow == null) {
                            $tahunBefore = explode("-", $row["tanggal"])[0];
                        } else {
                            $tahunBefore = $tahunNow;
                        }
                        $tahunNow = explode("-", $row["tanggal"])[0];
                        if ($tahunBefore == $tahunNow) {
                            $pemasukanTahunan = $pemasukanTahunan + $row["jumlah"] + $jumlahSementara;
                            $jumlahSementara = 0;
                        } else { ?>
                            <?php if ($pemasukanTahunan == 0) { ?>
                                <tr>
                                    <th class="text-center"><?= filter_var($i); ?></th>
                                    <td class="text-center"><?= filter_var($tahunBefore); ?></td>
                                    <td>Rp<?= number_format($jumlahSementara, 2, ",", "."); ?></td>
                                </tr>
                            <?php } else {
                                $satu = 0; ?>
                                <tr>
                                    <th class="text-center"><?= filter_var($i); ?></th>
                                    <td class="text-center"><?= filter_var($tahunBefore); ?></td>
                                    <td>Rp<?= number_format($pemasukanTahunan, 2, ",", "."); ?></td>
                                </tr>
                            <?php }
                            $i++;
                            $jumlahSementara = $row["jumlah"];
                            $totalPemasukan = $totalPemasukan + $pemasukanTahunan + $satu;
                            $pemasukanTahunan = 0;
                            $satu = $row["jumlah"]; ?>
                        <?php } ?>
                        <?php if ($x == sizeof($unionPemasukan)) { ?>
                            <?php if ($pemasukanTahunan == 0) {
                                $pemasukanTahunan = $row["jumlah"];
                            } ?>
                            <tr>
                                <th class="text-center"><?= filter_var($i); ?></th>
                                <td class="text-center"><?= filter_var($tahunNow); ?></td>
                                <td>Rp<?= number_format($pemasukanTahunan, 2, ",", "."); ?></td>
                            </tr>
                            <?php $i++;
                            $totalPemasukan = $totalPemasukan + $pemasukanTahunan;
                            $pemasukanTahunan = 0; ?>
                        <?php } ?>
                        <?php $x++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>
            <table class="table table-striped table-bordered table-sm col-md-6">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col" colspan="3">Pengeluaran</th>
                    </tr>
                    <tr>
                        <th scope="col" style="width: 90px">No.</th>
                        <th scope="col" style="width: 260px">Tahun</th>
                        <th scope="col" style="width: 150px">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    $angka_format = '0,00';
                    $tahunNow = null;
                    $pengeluaranTahunan = 0;
                    $jumlahSementara = 0;
                    $x = 1;
                    ?>
                    <?php foreach ($unionPengeluaran as $row) : ?>
                        <?php
                        if ($tahunNow == null) {
                            $tahunBefore = explode("-", $row["tanggal"])[0];
                        } else {
                            $tahunBefore = $tahunNow;
                        }
                        $tahunNow = explode("-", $row["tanggal"])[0];
                        if ($tahunBefore == $tahunNow) {
                            $pengeluaranTahunan = $pengeluaranTahunan + $row["jumlah"] + $jumlahSementara;
                            $jumlahSementara = 0;
                        } else { ?>
                            <?php if ($pengeluaranTahunan == 0) { ?>
                                <tr>
                                    <th class="text-center"><?= filter_var($i); ?></th>
                                    <td class="text-center"><?= filter_var($tahunBefore); ?></td>
                                    <td>Rp<?= number_format($jumlahSementara, 2, ",", "."); ?></td>
                                </tr>
                            <?php } else {
                                $satu = 0; ?>
                                <tr>
                                    <th class="text-center"><?= filter_var($i); ?></th>
                                    <td class="text-center"><?= filter_var($tahunBefore); ?></td>
                                    <td>Rp<?= number_format($pengeluaranTahunan, 2, ",", "."); ?></td>
                                </tr>
                            <?php }
                            $i++;
                            $jumlahSementara = $row["jumlah"];
                            $totalPengeluaran = $totalPengeluaran + $pengeluaranTahunan + $satu;
                            $pengeluaranTahunan = 0;
                            $satu = $row["jumlah"]; ?>
                        <?php } ?>
                        <?php if ($x == sizeof($unionPengeluaran)) { ?>
                            <?php if ($pengeluaranTahunan == 0) {
                                $pengeluaranTahunan = $row["jumlah"];
                            } ?>
                            <tr>
                                <th class="text-center"><?= filter_var($i); ?></th>
                                <td class="text-center"><?= filter_var($tahunNow); ?></td>
                                <td>Rp<?= number_format($pengeluaranTahunan, 2, ",", "."); ?></td>
                            </tr>
                            <?php $i++;
                            $totalPengeluaran = $totalPengeluaran + $pengeluaranTahunan;
                            $pengeluaranTahunan = 0; ?>
                        <?php } ?>
                        <?php $x++; ?>
                    <?php endforeach ?>
                </tbody>
            </table>

            <table class="table table-striped table-bordered table-sm tabel_bawah printShow" style="margin-top: -2.2%;">
                <tbody>
                    <?php
                    $total = $saldoAwal + $totalPemasukan;
                    $angka_format = number_format($total, 2, ",", ".");
                    $jumlah = $totalPemasukan - $totalPengeluaran;
                    $negativ = false;
                    $negativSA = false;
                    $saldoAkhir = $saldoAwal + $jumlah;
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
                        <th style="width: 155px"><?php echo $negativSA ? '-' : ''; ?>Rp<?= filter_var($saldo_akhir_format); ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= filter_var($angka_format); ?></th>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= filter_var($angka_format); ?></th>
                    </tr>
                </tbody>
            </table>

            <table class="table table-striped table-bordered table-sm tabel_bawah printInv">
                <tbody>
                    <?php
                    $total = $saldoAwal + $totalPemasukan;
                    $angka_format = number_format($total, 2, ",", ".");
                    $jumlah = $totalPemasukan - $totalPengeluaran;
                    $negativ = false;
                    $negativSA = false;
                    $saldoAkhir = $saldoAwal + $jumlah;
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
                        <th style="width: 150px"><?php echo $negativSA ? '-' : ''; ?>Rp<?= filter_var($saldo_akhir_format); ?></th>
                    </tr>
                    <tr>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= filter_var($angka_format); ?></th>
                        <td></td>
                        <th>Total : </th>
                        <th>Rp<?= filter_var($angka_format); ?></th>
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