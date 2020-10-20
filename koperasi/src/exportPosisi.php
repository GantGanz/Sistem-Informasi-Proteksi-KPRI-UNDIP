<?php
session_start();
if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

session_start();

require 'functions.php';

$awal = $_SESSION["awal"];
$akhir = $_SESSION["akhir"];
$pemasukkan = query("SELECT * FROM pemasukan WHERE awal >= '$awal' AND awal <= '$akhir'");
$pengeluaran = query("SELECT * FROM pengeluaran WHERE tgl_cair >= '$awal' AND tgl_cair <= '$akhir'");
$saldo = query("SELECT * FROM saldo")[0];

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=dana_proteksi_periode_tertentu.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>

<!DOCTYPE html>
<html lang="en">

<head>
</head>

<body>
    <?php
    $totalPemasukan = 0;
    $totalPengeluaran = 0;
    ?>
    <table border="1">
        <thead>
            <tr style="height: 30px; vertical-align:middle; text-align:center; font-size: 12px;">
                <th scope="col" colspan="3">Pemasukkan</th>
            </tr>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pemasukkan as $row) : ?>
                <tr>
                    <td><?= filter_var($row["awal"]); ?></td>
                    <td><?= filter_var($row["nama"]); ?></td>
                    <?php
                    $angka = $row["nominal_akhir"];
                    $totalPemasukan = $totalPemasukan + $angka;
                    $angka_format = number_format($angka, 2, ",", ".");
                    ?>
                    <td>Rp<?= filter_var($angka_format); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <table border="1">
        <thead>
            <tr style="height: 30px; vertical-align:middle; text-align:center; font-size: 12px;">
                <th scope="col" colspan="3">Pengeluaran</th>
            </tr>
            <tr>
                <th scope="col">Tanggal</th>
                <th scope="col">Keterangan</th>
                <th scope="col">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengeluaran as $row) : ?>
                <tr>
                    <td><?= filter_var($row["tgl_cair"]); ?></td>
                    <td><?= filter_var($row["nama"]); ?></td>
                    <?php
                    $angka = $row["nominal_cair"];
                    $totalPengeluaran = $totalPengeluaran + $angka;
                    $angka_format = number_format($angka, 2, ",", ".");
                    ?>
                    <td>Rp<?= filter_var($angka_format); ?></td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>
    <table border="1">
        <tbody style="height: 30px;">
            <tr>
                <?php
                $angka_format = number_format($totalPemasukan, 2, ",", ".");
                ?>
                <td>Total Pemasukkan :</td>
                <td>Rp<?= filter_var($angka_format); ?></td>
            </tr>
            <?php
            $angka_format = number_format($totalPengeluaran, 2, ",", ".");
            $jumlah = $totalPemasukan - $totalPengeluaran;
            $negativ = false;
            $negativ2 = false;
            if ($jumlah < 0) {
                $negativ = true;
            }
            $jumlah_format = number_format(abs($jumlah), 2, ",", ".");
            $saldo_akhir = $saldo["nominal"] + $jumlah;
            if ($saldo_akhir < 0) {
                $negativ2 = true;
            }
            $saldo_format = number_format(abs($saldo_akhir), 2, ",", ".");
            ?>
            <tr>
                <td>Total Pengeluaran :</td>
                <td>Rp<?= filter_var($angka_format); ?></td>
            </tr>
            <tr>
                <td>Jumlah Pendapatan Periode Ini :</td>
                <td><?php echo $negativ ? '-' : ''; ?>Rp<?= filter_var($jumlah_format); ?></td>
            </tr>
            <tr>
                <td>Saldo Sekarang :</td>
                <td><?php echo $negativ2 ? '-' : ''; ?>Rp<?= filter_var($saldo_format); ?></td>
            </tr>
        </tbody>
    </table>
</body>

</html>